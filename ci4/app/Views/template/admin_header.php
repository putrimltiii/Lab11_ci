<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
</head>
<body>
<div id="container">
    <header>
        <h1>Admin Portal Berita</h1>
    </header>
    <nav>
        <a href="<?= base_url('/admin/artikel'); ?>">Dashboard</a>
        <a href="<?= base_url('/artikel'); ?>">Artikel</a>
        <a href="<?= base_url('/admin/artikel/add'); ?>">Tambah Artikel</a>
        <a href="<?= base_url('/user/logout'); ?>"
           style="float:right; background:#e74c3c;"
           onclick="return confirm('Yakin ingin logout?');">Logout</a>
    </nav>
    <section id="wrapper">
        <section id="main">