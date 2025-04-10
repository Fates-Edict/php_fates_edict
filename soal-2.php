<?php
include 'connection.php';

$availableTabs = ['summary', 'hobbies', 'persons'];
$isTabValid = isset($_GET['tab']) ? in_array($_GET['tab'], $availableTabs) : header('Location: ' . '/soal-2.php?tab=summary');

$tabs = [
    ['label' => 'Report Summary', 'path' => 'summary'],
    ['label' => 'List Persons', 'path' => 'persons']
];

$tabActiveClass = 'whitespace-nowrap border-b-2 border-indigo-500 text-indigo-600 py-4 px-1 text-sm font-medium focus:outline-none';
$tabUnactiveClass = 'whitespace-nowrap border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium focus:outline-none';
$currentTab = $isTabValid ? $_GET['tab'] : header('Location: ' . '/soal-2.php?tab=summary');

$query = 'SELECT * FROM person';

if($currentTab === 'summary') {
    $query = "SELECT COUNT(h.person_id) AS total_person, h.hobi AS hobby ";
    $query .= "FROM hobi AS h ";
    if(isset($_POST['search'])) $query .= "WHERE h.hobi LIKE '%" . $_POST['search'] . "%' ";
    $query .= "GROUP BY h.hobi ";
    $query .= "ORDER BY total_person DESC";
} elseif($currentTab === 'persons') {
    $query = "SELECT p.id, p.nama as name, p.alamat as address, GROUP_CONCAT(h.hobi SEPARATOR ', ') as hobbies 
    FROM person as p
    LEFT JOIN hobi as h ON p.id = h.person_id
    GROUP BY p.id, p.nama, p.alamat;
    ";
}

$result = mysqli_query($conn, $query);

$data = [];
if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teramedik Soal 2A - PHP</title>
    <script src="/assets/tailwind.js"></script>
</head>
<body>
    <div class="bg-gray-100 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <?php foreach($tabs as $tab) : ?>
                        <a href="/soal-2.php?tab=<?= $tab['path'] ?>" 
                        class="<?= $currentTab === $tab['path'] ? $tabActiveClass : $tabUnactiveClass ?>">
                            <?= $tab['label'] ?>
                        </a>
                    <?php endforeach ?>
                </nav>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-3">
        <?php if($currentTab === 'summary') :?>
            <form action="" method="POST" class="flex items-center">
                <input type="text" name="search" placeholder="Search..." class="w-full px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>" />
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Search
                </button>
                <a href="/soal-2.php?tab=summary" class="px-4 py-2 bg-gray-300 text-black rounded-r-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 ml-2">
                    Reset
                </a>
            </form>
        <?php endif ?>
        <table class="min-w-full divide-y divide-gray-200">
            <?php if($currentTab === 'summary') : ?>
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Hobby
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total Persons
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach($data as $row) : ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $row['hobby'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $row['total_person'] ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            <?php elseif($currentTab === 'persons') : ?>
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Address
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Hobbies
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach($data as $row) : ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $row['name'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $row['address'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $row['hobbies'] ?? '-' ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            <?php endif ?>
        </table>
    </div>
</body>
</html>