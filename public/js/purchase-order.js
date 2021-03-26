var api = "http://localhost:8000/api";

function addToCart(productId) {
  let po = getLastPO(productId);
}

function administrarDetail(productId, quantity, po) {
  // console.log("administrarDetail():");
  let details = po.detailsPO;

  let found = false;
  // increase quantity
  details.forEach((element, key) => {
    console.log(element);

    if (element.productId == productId) {
      element.quantity = parseInt(quantity) + parseInt(element.quantity);
      found = true;
    }
  });

  if (!found) {
    po.detailsPO.push({
      quantity: quantity,
      productId: productId,
    });
  }

  console.log("found: " + found);
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

async function getLastPO(productId) {
  let quantity = 1;
  if (document.getElementById("input_quant")) {
    quantity = document.getElementById("input_quant").value;
  }

  $.ajax({
    url: api + "/purchase-order/get",
    type: "GET",
    dataType: "json",
    error: function (error) {
      console.log("Error:");
      console.log(error);
    },
  }).done(function (data) {
    console.log(data);
    if (data["data"]) administrarDetail(productId, quantity, data.data);
    else {
      let po = new Object();
      po["detailsPO"] = [
        {
          productId: productId,
          quantity: parseInt(quantity),
        },
      ];
      callPOControl(po);
    }
  });
}

function callPOControl(po) {
  // console.log("callPOControl");
  // console.log(po);
  $.ajax({
    url: api + "/purchase-order/new",
    type: "POST",
    dataType: "json",
    data: JSON.stringify(po),
    success: function (data) {
      console.log(data);
      // alert of changement
      CWdialog(data.status + ": article added");
    },
    error: function (error) {
      console.log("Error:");
      console.log(error);
    },
  });
}
