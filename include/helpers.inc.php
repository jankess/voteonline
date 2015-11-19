<?php
function html($text)
{
  return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function htmlout($text)
{
  echo html($text);
}

function markdown2html($text)
{
  $text = html($text);

  // Mocne wyróżnienie
  $text = preg_replace('/__(.+?)__/s', '<strong>$1</strong>', $text);
  $text = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $text);

  // Wyróżnienie
  $text = preg_replace('/_([^_]+)_/', '<em>$1</em>', $text);
  $text = preg_replace('/\*([^\*]+)\*/', '<em>$1</em>', $text);

  // Z systemu Windows (\r\n) na system Unix (\n)
  $text = str_replace("\r\n", "\n", $text);
  // Z komputerów Macintosh (\r) na system Unix (\n)
  $text = str_replace("\r", "\n", $text);

  // Akapity
  $text = '<p>' . str_replace("\n\n", '</p><p>', $text) . '</p>';
  // Podział wierszy
  $text = str_replace("\n", '<br>', $text);

  // [aktywny tekst](adres URL)
  $text = preg_replace(
      '/\[([^\]]+)]\(([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)\)/i',
      '<a href="$2">$1</a>', $text);

  return $text;
}

function markdownout($text)
{
  echo markdown2html($text);
}
