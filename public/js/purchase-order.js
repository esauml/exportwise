var api = "http://localhost:8000/api";

async function addToCart(productId) {
  let po = await getLastPO(productId);
}

function administrarDetail(productId, quantity, po) {
  let details = po["detailsPO"];

  let found = false;
  // increase quantity
  details.forEach((element) => {
    // console.log(element);

    if (element["productId"] == productId) {
      element["quantity"] =
        parseInt(quantity) + parseInt(element["quantity"], 10);
      found = true;
    }
  });

  if (!found) {
    po["detailsPO"].push({
      quantity: quantity,
      productId: productId,
    });
  }

  callPOControl(po);

  // if (details[productId] != null) {
  //   details[productId]["quantity"]++;
  // } else {
  //   details[productId] = {
  //     quantity: 1,
  //     productId: productId,
  //   };
  // }
}

function getLastPO(productId) {
  let quantity = 1;
  if (document.getElementById("input_quant")) {
    quantity = document.getElementById("input_quant").value;
  }

  $.ajax({
    url: api + "/purchase-order/get",
    type: "GET",
    dataType: "json",
    success: function (data) {
      console.log(data);
      if (data["data"]) administrarDetail(productId, quantity, data["data"]);
      else {
        let po = new Object();
        po["detailsPO"] = [
          {
            productId: productId,
            quantity: quantity,
          },
        ];
        callPOControl(po);
      }
    },
    error: function (error) {
      console.log("Error:");
      console.log(error);
    },
  });
}

function callPOControl(po) {
  $.ajax({
    url: api + "/purchase-order/new",
    type: "POST",
    dataType: "json",
    data: JSON.stringify(po),
    success: function (data) {
      console.log(data);
    },
    error: function (error) {
      console.log("Error:");
      console.log(error);
    },
  });
}
