<?php

namespace App\Services;

use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\Process;

class RestrictedPhpRunner
{
    private const BLOCKED_TOKENS = [
        T_TRAIT, T_ENUM, T_INCLUDE, T_INCLUDE_ONCE,
        T_REQUIRE, T_REQUIRE_ONCE, T_EVAL, T_EXIT, T_GOTO, T_NAMESPACE, T_USE,
    ];

    private const BLOCKED_CALLS = [
        'exec', 'shell_exec', 'system', 'passthru', 'proc_open', 'popen', 'pcntl_exec',
        'file', 'file_get_contents', 'file_put_contents', 'fopen', 'fwrite', 'unlink',
        'rename', 'copy', 'mkdir', 'rmdir', 'glob', 'scandir', 'curl_exec', 'fsockopen',
        'stream_socket_client', 'putenv', 'ini_set', 'set_time_limit', 'header', 'mail',
        'call_user_func', 'call_user_func_array', 'forward_static_call',
    ];

    private const BLOCKED_CLASSES = [
        'pdo', 'phar', 'phardata', 'reflectionclass', 'reflectionfunction',
        'directoryiterator', 'filesystemiterator', 'splfileobject', 'soapclient', 'ffi',
    ];

    public function run(string $code): CodeExecutionResult
    {
        if (mb_strlen($code) > 10_000) {
            return new CodeExecutionResult(false, '', 'O código deve ter no máximo 10.000 caracteres.');
        }

        if ($error = $this->securityError($code)) {
            return new CodeExecutionResult(false, '', $error);
        }

        $directory = null;
        $file = null;
        try {
            $directory = sys_get_temp_dir().'/loop-lab-sandbox-'.bin2hex(random_bytes(12));
            if (! mkdir($directory, 0700, true) && ! is_dir($directory)) {
                throw new \RuntimeException('Não foi possível criar o ambiente temporário.');
            }

            $file = $directory.'/solution.php';
            if (file_put_contents($file, $code) === false) {
                throw new \RuntimeException('Não foi possível preparar o código para execução.');
            }

            $disabled = implode(',', self::BLOCKED_CALLS);
            $phpBinary = $this->phpBinary();
            $process = new Process([
                $phpBinary, '-n', '-d', 'display_errors=stderr', '-d', 'memory_limit=32M',
                '-d', 'max_execution_time=1', '-d', "open_basedir=$directory", '-d', "disable_functions=$disabled", $file,
            ], $directory, [], null, 2);

            $started = hrtime(true);
            $process->run();
            $milliseconds = (int) ((hrtime(true) - $started) / 1_000_000);

            if (! $process->isSuccessful()) {
                return new CodeExecutionResult(false, $process->getOutput(), $this->friendlyError($process->getErrorOutput()), $milliseconds);
            }

            return new CodeExecutionResult(true, $process->getOutput(), '', $milliseconds);
        } catch (ProcessTimedOutException) {
            return new CodeExecutionResult(false, '', 'Tempo excedido. Verifique se você criou um loop infinito.', 2000);
        } catch (\Throwable $error) {
            report($error);

            return new CodeExecutionResult(false, '', 'O servidor não conseguiu iniciar o executor PHP. Tente novamente em instantes.');
        } finally {
            if ($file) {
                @unlink($file);
            }
            if ($directory) {
                @rmdir($directory);
            }
        }
    }

    private function phpBinary(): string
    {
        $configured = getenv('PHP_CLI_BINARY') ?: null;
        $binaryName = PHP_OS_FAMILY === 'Windows' ? 'php.exe' : 'php';
        $pathCandidates = array_filter([
            $configured,
            PHP_BINDIR.DIRECTORY_SEPARATOR.$binaryName,
            PHP_BINARY,
            '/usr/local/bin/php',
            '/usr/bin/php',
            '/usr/bin/php8.3',
            '/usr/bin/php8.2',
            '/usr/local/bin/php8.3',
        ]);

        foreach ($pathCandidates as $candidate) {
            if (is_string($candidate) && $candidate !== '' && is_file($candidate) && is_executable($candidate)) {
                return $candidate;
            }
        }

        $resolved = trim((string) @shell_exec('command -v php || which php || true'));
        if ($resolved !== '') {
            return $resolved;
        }

        throw new \RuntimeException('O executável PHP CLI não foi encontrado.');
    }

    private function securityError(string $code): ?string
    {
        foreach (token_get_all($code) as $token) {
            if (! is_array($token)) {
                continue;
            }
            if (in_array($token[0], self::BLOCKED_TOKENS, true)) {
                return 'Este recurso não é permitido no ambiente de exercícios.';
            }
            if ($token[0] === T_STRING && in_array(strtolower($token[1]), self::BLOCKED_CALLS, true)) {
                return "A função {$token[1]} não é permitida no ambiente de exercícios.";
            }
            if ($token[0] === T_STRING && in_array(strtolower($token[1]), self::BLOCKED_CLASSES, true)) {
                return "A classe {$token[1]} não é permitida no ambiente de exercícios.";
            }
        }

        return null;
    }

    private function friendlyError(string $error): string
    {
        if (str_contains($error, 'Maximum execution time')) {
            return 'Tempo excedido. Verifique se você criou um loop infinito.';
        }

        $error = preg_replace('/ in .*solution\.php on line /', ' na linha ', trim($error)) ?? trim($error);

        return $error ?: 'Não foi possível executar o código.';
    }
}
