<?php require 'header.php'; ?>
<?php require 'db.php'; ?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="colorlib.com">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet" />
    <link href="css/filter/filter.css" rel="stylesheet" />
  </head>
  <body>
    <!-- Filter Form Section-->
    <div class="s002">
      <form id="filterForm" class="modal-content">
        <div class="inner-form">
          <div class="input-field first-wrap">
            <div class="icon-wrap">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5 2.5-1.12 2.5-2.5 2.5z"></path>
              </svg>
            </div>
            <input id="search" type="text" placeholder="Where are you looking for?" name="search_location"/>
          </div>
          <div class="input-field fouth-wrap">
            <div class="icon-wrap">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
              </svg>
            </div>
            <select data-trigger="" name="search_type">
              <option placeholder="">Type</option>
              <option value="1">Single</option>
              <option value="2">Double</option>
              <option value="3">Family</option>
            </select>
          </div>
          <div class="input-field fifth-wrap">
            <input type="button" name="submit" value="SEARCH" class="btn btn-search" onclick="applySearch()">
          </div>
        </div>
      </form>
    </div>

    <script src="js/extention/choices.js"></script>
    <script src="js/extention/flatpickr.js"></script>
    <script>
      flatpickr(".datepicker", {});
      const choices = new Choices('[data-trigger]', {
        searchEnabled: false,
        itemSelectText: '',
      });
    </script>

    <!-- Room Section with Sorting Option -->
    <section class="py-5">
      <div class="container px-4 px-lg-5 mt-5">
        <div class="row">
          <div class="col-md-3">
            <label for="sort_price">Sort by Price:</label>
            <select id="sort_price" class="form-select">
              <option value="">Select</option>
              <option value="asc">Low to High</option>
              <option value="desc">High to Low</option>
            </select>
          </div>
          <div class="col-md-9">
            <div id="room-list" class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
              <!-- Room listings will be loaded here dynamically -->
            </div>
          </div>
        </div>
      </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    
    <script>
      // This function will apply the search filters
      function applySearch() {
        const searchLocation = document.getElementById('search').value;
        const searchType = document.querySelector('[name="search_type"]').value;

        fetchRooms(searchLocation, searchType, "");
      }

      // Event listener for sorting
      document.getElementById("sort_price").addEventListener("change", function() {
        const sortOrder = this.value;
        const searchLocation = document.getElementById('search').value;
        const searchType = document.querySelector('[name="search_type"]').value;

        fetchRooms(searchLocation, searchType, sortOrder);
      });

      // Fetch rooms based on search filters and sorting
      function fetchRooms(location, type, sortOrder) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "fetch_rooms.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("room-list").innerHTML = xhr.responseText;
          }
        };
        xhr.send("search_location=" + encodeURIComponent(location) + 
                 "&search_type=" + encodeURIComponent(type) + 
                 "&sort_order=" + encodeURIComponent(sortOrder));
      }

      // Initial load without any search
      fetchRooms("", "", "");
    </script>
    <?php require 'footer.php' ?> 
  </body>
</html>
