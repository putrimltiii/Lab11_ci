<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'BreakingNewsID'; ?></title>
    <link rel="stylesheet" href="<?= base_url('style.css'); ?>">
</head>
<body>
<div id="container">
    <header>
        <h1>BreakingNewsID</h1>
    </header>
    <nav>
        <a href="<?= base_url('/'); ?>">Home</a>
        <a href="<?= base_url('/artikel'); ?>">Artikel</a>
        <a href="<?= base_url('/about'); ?>">About</a>
        <a href="<?= base_url('/contact'); ?>">Contact</a>
        <a href="<?= base_url('/user/login'); ?>" style="float:right;">Login Admin</a>
    </nav>
    <section id="wrapper">
        <section id="main">