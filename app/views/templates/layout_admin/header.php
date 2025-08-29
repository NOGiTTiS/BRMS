<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?> - <?php echo SITENAME; ?></title>

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font: Prompt -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Heroicons for icons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    
    <!-- SweetAlert2 & Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { font-family: 'Prompt', sans-serif; }
        /* Custom scrollbar for better look */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #f472b6; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #ec4899; }
    </style>
</head>
<body class="bg-gradient-to-br from-pink-100 via-purple-100 to-indigo-200">

<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/templates/layout_admin/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navbar -->
        <?php require APPROOT . '/views/templates/layout_admin/navbar.php'; ?>
        
        <!-- Content Body -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100/50">
            <div class="container mx-auto px-6 py-8">
                <!-- Start Content Here -->