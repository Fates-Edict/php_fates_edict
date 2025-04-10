<?php 
    $params = isset($_GET['params']) ? $_GET['params'] : null;
    $totalRows = isset($_POST['rows']) ? $_POST['rows'] : null;
    $totalColumns = isset($_POST['columns']) ? $_POST['columns'] : null;
    $showFinalResult = isset($_POST['showFinalResult']) && $_POST['showFinalResult'] === 'true';
    $matrix = isset($_POST['matrix']) ? $_POST['matrix'] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teramedik Soal 1A - PHP</title>
    <script src="/assets/tailwind.js"></script>
</head>
<body>
    <?php if($showFinalResult && $totalRows && $totalColumns) : ?>
        <div class="p-10 w-screen h-screen flex flex-col">
            <div class="mb-5">
                <a href="/soal-1.php" class="cursor-pointer bg-blue-600 text-white font-semibold py-2 w-full px-5 rounded shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300">
                    Re-Input
                </a>
            </div>

            <div class="p-5 rounded border border-gray-300 w-full h-full overflow-x-auto">
                <?php for($i = 0; $i < $totalRows; $i++) : ?>
                    <div class="flex gap-2">
                        <?php for($j = 0; $j < $totalColumns; $j++) : ?>
                            <span class="font-bold"><?= $i + 1 . '.' . $j + 1 . ': ' ?> </span>
                            <?= ($matrix[$i][$j] != '' ? $matrix[$i][$j] : '-') ?>
                        <?php endfor ?>
                    </div>
                <?php endfor ?>
            </div>
        </div>

    <?php elseif(!$totalRows || !$totalColumns) : ?>
        <div class="h-screen w-screen flex items-center justify-center">
            <form action="/soal-1.php" method="POST" class="p-10 border border-gray-300 rounded" autocomplete="off">
                <div class="mb-4">
                    <label for="rows" class="block text-sm font-medium text-gray-700">Input Jumlah Baris</label>
                    <input
                        autofocus
                        id="rows"
                        name="rows" 
                        type="number" 
                        class="mt-1 block w-full px-4 py-1 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                        placeholder="Input Jumlah Baris"
                        value="<?= $totalRows ?>"
                    />
                </div>

                <div class="mb-4">
                    <label for="columns" class="block text-sm font-medium text-gray-700">Input Jumlah Kolom</label>
                    <input
                        id="columns"
                        name="columns" 
                        type="number" 
                        class="mt-1 block w-full px-4 py-1 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                        placeholder="Input Jumlah Kolom"
                        value="<?= $totalColumns ?>"
                    />
                </div>

                <button type="submit" class="cursor-pointer bg-blue-600 text-white font-semibold py-2 w-full px-4 rounded shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300">
                    Submit
                </button>

                <div class="text-center mt-3">
                    <a href="/" class="underline font-bold cursor-pointer text-blue-300">Back to Home</a>
                </div>
            </form>
        </div>
    
    <?php elseif($totalRows && $totalColumns) : ?>
        <div class="p-10 flex flex-col">
            <div class="mb-5">
                <a href="/soal-1.php" class="cursor-pointer bg-blue-600 text-white font-semibold py-2 w-full px-5 rounded shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300">
                    Back
                </a>
            </div>
            
            <form action="/soal-1.php" method="POST" class="py-10 px-5 border border-gray-300 rounded grid grid-cols-8 gap-2 items-center" autocomplete="off">
                <input type="hidden" value="true" name="showFinalResult" />
                <input type="hidden" value="<?= $totalRows ?>" name="rows" />
                <input type="hidden" value="<?= $totalColumns ?>" name="columns" />

                <?php for($i = 0; $i < $totalRows; $i++ ) : ?>
                    <?php for($j = 0; $j < $totalColumns; $j++) : ?>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700"><?= $i + 1 . '.' . $j + 1 . ':'?></label>
                            <input
                                name="matrix[<?= $i ?>][<?= $j ?>]"
                                class="mt-1 block w-full px-4 py-1 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                placeholder="Input <?= $i + 1 . '.' . $j + 1 ?>"
                            />
                        </div>
                    <?php endfor ?>
                <?php endfor ?>
                
                <div class="col-span-8 text-center">
                    <button type="submit" class="cursor-pointer bg-blue-600 text-white font-semibold py-2 w-[15%] px-4 rounded shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    <?php endif ?>
</body>
</html>