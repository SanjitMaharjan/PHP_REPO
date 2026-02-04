<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Compact Bike Card</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="w-80 bg-white rounded-xl shadow-md hover:shadow-lg transition">
    
    <!-- Image (shorter height) -->
<img 
  src="<?php echo $row["image"]?>"
  alt="Honda Bike"
  class="w-full h-100 object-contain bg-gray-100 rounded-t-xl"
/>

    <!-- Content -->
    <div class="p-4">
      <h2 class="text-lg font-semibold text-gray-800 mb-2">
        <?php echo $row["name"]?>
      </h2>

      <table class="w-full text-sm text-gray-600">
        <tr>
          <td class="py-1 font-medium">Company</td>
          <td class="py-1 text-right"><?php echo $row["company"]?></td>
        </tr>
        <tr>
          <td class="py-1 font-medium">CC</td>
          <td class="py-1 text-right"><?php echo $row["cc"]?></td>
        </tr>
        <tr>
          <td class="py-1 font-medium">Price</td>
          <td class="py-1 text-right font-semibold text-green-600">
            <?php echo $row["price"]?>
          </td>
        </tr>
      </table>

      <!-- <button class="mt-3 w-full bg-black text-white text-sm py-1.5 rounded-md hover:bg-gray-800 transition">
        Buy Now
      </button> -->
    </div>
  </div>

</body>
</html>
