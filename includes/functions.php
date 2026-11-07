<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): never
{
    header('Location: ' . BASE_URL . $path);
    exit;
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function show_flash(): void
{
    if (empty($_SESSION['flash'])) {
        return;
    }

    $item = $_SESSION['flash'];
    unset($_SESSION['flash']);

    echo '<div class="alert alert-' . e($item['type']) . '">' . e($item['message']) . '</div>';
}

function post(string $key): string
{
    return trim((string) ($_POST[$key] ?? ''));
}

function valid_date(string $date): bool
{
    $parsedDate = DateTime::createFromFormat('Y-m-d', $date);
    return $parsedDate && $parsedDate->format('Y-m-d') === $date;
}

function integer(string $value, int $minimum = 0): ?int
{
    $result = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => $minimum]]);
    return $result !== false ? (int) $result : null;
}