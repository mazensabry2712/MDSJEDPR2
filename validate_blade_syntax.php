<?php

/**
 * Blade Syntax Validator
 * للتحقق من صحة تركيب ملفات Blade
 */

$filePath = __DIR__ . '/resources/views/dashboard/invoice/index.blade.php';

if (!file_exists($filePath)) {
    echo "File not found!\n";
    exit(1);
}

echo "\n========================================\n";
echo "  BLADE SYNTAX VALIDATOR\n";
echo "========================================\n\n";

$content = file_get_contents($filePath);
$lines = explode("\n", $content);

// Track opening and closing directives
$stack = [];
$errors = [];

foreach ($lines as $lineNum => $line) {
    $lineNumber = $lineNum + 1;

    // Check for @if
    if (preg_match('/@if\s*\(/', $line)) {
        $stack[] = ['type' => 'if', 'line' => $lineNumber];
    }

    // Check for @foreach
    if (preg_match('/@foreach\s*\(/', $line)) {
        $stack[] = ['type' => 'foreach', 'line' => $lineNumber];
    }

    // Check for @can
    if (preg_match('/@can\s*\([\'"]/', $line)) {
        $stack[] = ['type' => 'can', 'line' => $lineNumber];
    }

    // Check for @else (just note it, doesn't affect stack)
    if (preg_match('/@else\s*$/', $line)) {
        if (empty($stack)) {
            $errors[] = "Line {$lineNumber}: @else without matching @if";
        }
    }

    // Check for @endif
    if (preg_match('/@endif\s*$/', $line)) {
        if (empty($stack)) {
            $errors[] = "Line {$lineNumber}: @endif without matching @if";
        } else {
            $last = array_pop($stack);
            if ($last['type'] !== 'if') {
                $errors[] = "Line {$lineNumber}: @endif found but expected @end{$last['type']} (opened at line {$last['line']})";
                $stack[] = $last; // Put it back
            }
        }
    }

    // Check for @endforeach
    if (preg_match('/@endforeach\s*$/', $line)) {
        if (empty($stack)) {
            $errors[] = "Line {$lineNumber}: @endforeach without matching @foreach";
        } else {
            $last = array_pop($stack);
            if ($last['type'] !== 'foreach') {
                $errors[] = "Line {$lineNumber}: @endforeach found but expected @end{$last['type']} (opened at line {$last['line']})";
                $stack[] = $last; // Put it back
            }
        }
    }

    // Check for @endcan
    if (preg_match('/@endcan\s*$/', $line)) {
        if (empty($stack)) {
            $errors[] = "Line {$lineNumber}: @endcan without matching @can";
        } else {
            $last = array_pop($stack);
            if ($last['type'] !== 'can') {
                $errors[] = "Line {$lineNumber}: @endcan found but expected @end{$last['type']} (opened at line {$last['line']})";
                $stack[] = $last; // Put it back
            }
        }
    }
}

// Check for unclosed directives
if (!empty($stack)) {
    foreach ($stack as $item) {
        $errors[] = "Line {$item['line']}: Unclosed @{$item['type']} directive";
    }
}

// Report results
if (empty($errors)) {
    echo "✅ No syntax errors found!\n";
    echo "   All @if/@endif, @foreach/@endforeach, and @can/@endcan are properly balanced.\n";
} else {
    echo "❌ SYNTAX ERRORS FOUND:\n\n";
    foreach ($errors as $error) {
        echo "  • {$error}\n";
    }
}

echo "\n========================================\n";
echo "  Total lines checked: " . count($lines) . "\n";
echo "  Errors found: " . count($errors) . "\n";
echo "========================================\n\n";
