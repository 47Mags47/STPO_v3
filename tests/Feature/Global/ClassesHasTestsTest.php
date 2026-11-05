<?php

namespace Tests\Feature\Global;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\DataProvider;
use SplFileInfo;
use Tests\Feature\TestCase;

class ClassesHasTestsTest extends TestCase
{
    protected static function getFolderClasses(string $dir): array
    {
        if (!is_dir($dir)) {
            return [];
        }

        $entries = scandir($dir) ?: [];
        $classes = [];

        foreach ($entries as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }

            $fullPath = $dir . '/' . $entry;

            if (is_dir($fullPath)) {
                foreach (self::getFolderClasses($fullPath) as $nested) {
                    $classes[] = $entry.'/'.$nested;
                }
            } elseif (pathinfo($entry, PATHINFO_EXTENSION) === 'php') {
                $classes[] = pathinfo($entry, PATHINFO_FILENAME);
            }
        }

        return $classes;
    }

    protected static function projectPath(string $relative): string
    {
        return dirname(__DIR__, 3) . '/' . $relative;
    }

    ### PROVIDERS
    ##################################################
    public static function controllersProvider(): iterable
    {
        foreach (self::getFolderClasses(self::projectPath('app/Http/Controllers')) as $controller) {
            yield $controller => [$controller];
        }
    }

    public static function modelsProvider(): iterable
    {
        foreach (self::getFolderClasses(self::projectPath('app/Models')) as $model) {
            yield $model => [$model];
        }
    }

    public static function policyProvider(): iterable
    {
        foreach (self::getFolderClasses(self::projectPath('app/Policies')) as $policy) {
            yield $policy => [$policy];
        }
    }

    ### TESTS
    ##################################################
    // #[DataProvider('controllersProvider')]
    // public function test_controller_has_a_feature_test(string $controller)
    // {
    //     $testNamespace = 'Tests\\Feature\\Controller\\Tests\\';
    //     $testClass = str_replace('/', '\\', $testNamespace . $controller.'Test');
    //     $this->assertTrue(class_exists($testClass), 'Не найден тест: '.$testClass);
    // }

    // #[DataProvider('modelsProvider')]
    // public function test_model_has_a_feature_test(string $model)
    // {
    //     $testNamespace = 'Tests\\Feature\\Model\\Tests\\';
    //     $testClass = str_replace('/', '\\', $testNamespace . $model.'Test');
    //     $this->assertTrue(class_exists($testClass), 'Не найден тест: '.$testClass);
    // }

    // #[DataProvider('policyProvider')]
    // public function test_policy_has_a_feature_test(string $policy)
    // {
    //     $testNamespace = 'Tests\\Feature\\Policy\\Tests\\';
    //     $testClass = str_replace('/', '\\', $testNamespace . $policy.'Test');
    //     $this->assertTrue(class_exists($testClass), 'Не найден тест: '.$testClass);
    // }
}
