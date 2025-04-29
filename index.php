<?php
include 'koneksi.php';
$result = $conn->query("SELECT * FROM tasks ORDER BY tanggal ASC");

// Query untuk menghitung jumlah tugas
$totalTasks = $conn->query("SELECT COUNT(*) AS total FROM tasks")->fetch_assoc()['total'];
$completedTasks = $conn->query("SELECT COUNT(*) AS total FROM tasks WHERE status='selesai'")->fetch_assoc()['total'];
$pendingTasks = $conn->query("SELECT COUNT(*) AS total FROM tasks WHERE status!='selesai'")->fetch_assoc()['total'];

$result = $conn->query("SELECT * FROM tasks ORDER BY tanggal ASC");
?>



<!DOCTYPE html>
<html>

<head>
  <title>ToDoList App</title>
  <link rel="icon" href="img/checklist.png" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="bg-gradient-to-r from-indigo-400 to-blue-200 min-h-screen">
  <div class="container mx-auto px-4 py-8 max-w-5xl">
    <div class="bg-white rounded-lg shadow-lg">
      <!-- Header -->
      <div class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-6 py-4 text-center rounded-t-lg">
        <h2 class="text-3xl font-bold">Daftar Tugas Rangga XII RPL 1</h2>
      </div>

      <!-- Statistik tugas -->
      <div class="p-4 bg-gray-50 border-b border-gray-200">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-center">
          <div class="bg-white shadow rounded-lg p-2 flex items-center justify-between">
            <h3 class="text-sm font-medium text-gray-700">Total Tugas</h3>
            <p class="text-lg font-bold text-blue-500"><?= $totalTasks ?></p>
          </div>
          <div class="bg-white shadow rounded-lg p-2 flex items-center justify-between">
            <h3 class="text-sm font-medium text-gray-700">Tugas Selesai</h3>
            <p class="text-lg font-bold text-green-500"><?= $completedTasks ?></p>
          </div>
          <div class="bg-white shadow rounded-lg p-2 flex items-center justify-between">
            <h3 class="text-sm font-medium text-gray-700">Tugas Belum Selesai</h3>
            <p class="text-lg font-bold text-red-500"><?= $pendingTasks ?></p>
          </div>
        </div>
      </div>

      <!-- Form tambah data -->
      <div class="p-6 border-b">
        <form action="tambah.php" method="POST" class="space-y-4 md:flex md:items-end md:space-x-4">
          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700">Nama Tugas</label>
            <input type="text" name="nama_tugas" placeholder="Masukkan nama tugas" required
              class="w-full px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500">
          </div>
          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700">Prioritas</label>
            <select name="prioritas" required
              class="w-full px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500">
              <option value="" disabled selected>Pilih Prioritas</option>
              <option value="Tinggi">Tinggi</option>
              <option value="Sedang">Sedang</option>
              <option value="Rendah">Rendah</option>
            </select>
          </div>
          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" name="tanggal" required
              class="w-full px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500">
          </div>
          <button type="submit"
            class="px-4 py-2 bg-indigo-500 text-white font-medium rounded-md hover:bg-indigo-600 focus:ring-2 focus:ring-indigo-500">
            Tambah
          </button>
        </form>
      </div>

      <!-- List tugas -->
      <div class="p-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg">
          <thead class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">No</th>
              <th class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">Nama Tugas</th>
              <th class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">Prioritas</th>
              <th class="px-6 py-3 text-left text-xs font-medium  tracking-wider">Tanggal</th>
              <th class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php $no = 1;
            while ($row = $result->fetch_assoc()): ?>
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-500"><?= $no++ ?></td>
                <td class="px-6 py-4 text-sm <?= $row['status'] == 'selesai' ? 'line-through text-gray-400' : 'text-gray-900' ?>">
                  <?= $row['nama_tugas'] ?>
                </td>
                <td class="px-6 py-4 text-sm">
                  <span class="px-2 inline-flex text-xs font-semibold rounded-full <?= strtolower($row['prioritas']) == 'tinggi' ? 'bg-red-100 text-red-800' : (strtolower($row['prioritas']) == 'sedang' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') ?>">
                    <?= $row['prioritas'] ?>
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500"><?= $row['tanggal'] ?></td>
                <td class="px-6 py-4 text-sm">
                  <span class="px-2 inline-flex text-xs font-semibold rounded-full <?= $row['status'] == 'selesai' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                    <?= $row['status'] ?>
                  </span>
                </td>
                <td class="px-6 py-4 text-sm space-x-2">
                  <a href="edit.php?id=<?= $row['id'] ?>" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>
                  <a href="selesai.php?id=<?= $row['id'] ?>"
                  onclick="return confirm('Yakinkah tugas lo udh selesai?')" class="px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600">Selesai</a>
                  <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin emng mau ngehapus tugas ini? klik OK jika ingin menghapus')" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>

            <?php if ($result->num_rows === 0): ?>
              <tr>
                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Alhamdulillah ngga ada tugaasss.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>