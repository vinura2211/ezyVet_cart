<?php
  $products = [
    [ "name" => "Sledgehammer", "price" => 125.75  ],
    [ "name" => "Axe",          "price" => 190.50  ],
    [ "name" => "Bandsaw",      "price" => 562.131 ],
    [ "name" => "Chisel",       "price" =>  12.9    ],
    [ "name" => "Hacksaw",      "price" =>  18.45   ]
  ];

  session_start();

  for ($I = 0; $I < count($products); $I++)
  {
    if(isset($_POST["add_to_cart{$I}"]))
    {
      $item_array = array(
        "item_name" => $_POST["hidden_name{$I}"],
        "item_quantity" => $_POST["quantity{$I}"],
        "item_price" => $_POST["hidden_price{$I}"]
      );
      $_SESSION["shopping_cart"][$I] = $item_array;
    }
  }

  if(isset($_GET["action"]))
  {
    if($_GET["action"] == "delete")
    {
      foreach($_SESSION["shopping_cart"] as $keys => $values)
      {
        if($values["item_name"] == $_GET["id"])
        {
          unset($_SESSION["shopping_cart"][$keys]);
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Shopping Cart</title>
    <style>
table, th, td
{
  border: 1.5px solid black;
  border-collapse: collapse;
}
</style>
  </head>
  <body>
    <h1 align="center"> Products </h1>

    <?php
      for($i = 0; $i < count($products); $i++)
      {
    ?>
      <div class="col-md-4">
        <form method="post" action="cart.php">
          <div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="centre">

            <h3><?php echo $products[$i]["name"]; ?></h3>

            <h3>$<?php echo number_format($products[$i]["price"], 2); ?></h3>

            <input type="number" name=<?php echo "quantity{$i}";?> value=1 />

            <input type="hidden" name=<?php echo "hidden_name{$i}" ?> value = "<?php echo $products[$i]["name"]; ?>" />

            <input type="hidden" name=<?php echo "hidden_price{$i}"?> value="<?php echo number_format($products[$i]["price"], 2); ?>" />

            <input type="submit" name=<?php echo "add_to_cart{$i}" ?> class="btn btn-sucess" value="Add to Cart" />

          </div>
        </form>
      </div>
    <?php
      }
    ?>

    <br />

    <h1 align="center">Cart</h1>
      <table>
        <tr>
          <th width="40%" align="left">Product Name</th>
          <th width="15%" align="left">Price</th>
          <th width="15%" align="left">Quantity</th>
          <th width="15%" align="left">Total</th>
          <th width="5%"  align="left">Action</th>
        </tr>
        <?php
        if(!empty($_SESSION["shopping_cart"]))
        {
          $total = 0;
          foreach($_SESSION["shopping_cart"] as $keys => $values)
          {
        ?>
        <tr>
          <td><?php echo $values["item_name"]; ?></td>
          <td align="right">$ <?php echo $values["item_price"]; ?></td>
          <td align="right"><?php echo $values["item_quantity"] ?></td>
          <td align="right">$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
          <td><a href="cart.php?action=delete&id=<?php echo $values["item_name"]; ?>"><span>Remove</span></a></td>
        </tr>
        <?php
            $total = $total + ($values["item_quantity"] * $values["item_price"]);
          }
        ?>
        <tr>
          <td colspan="3" align="right">Total</td>
          <td align="right">$ <?php echo number_format($total, 2); ?></td>
          <td></td>
        </tr>
        <?php
        }
        ?>

      </table>
    <br />
    </body>
    </html>
