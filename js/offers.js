window.addEventListener('load', function () {
    "use strict";

    const URL = 'getOffers.php';

    /*Function to use AJAX to display different toys as a flash offer */
    const fetchData = function() {
        fetch(URL)
    .then(  
      function (response) {
          if(response.status === 200) {
            return response.json();
          }
          else {
              throw new Error("Invalid response");
          }
      }
     )
    .then( 
      function (json) {
        document.getElementById("offers").innerHTML = "<h1>" +json.toyName + "</h1>";
        document.getElementById("offers").innerHTML += "<h2>" +json.catDesc + "</h2>";
        document.getElementById("offers").innerHTML += "<h3>£" +json.toyPrice + "</h3>";
      }
    )
    .catch(
      function (err) {
        console.log("Something went wrong!", err);
      }
    ); 
    }

    fetchData();
    setInterval(fetchData, 5000);
    

});