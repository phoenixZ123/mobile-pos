</main>

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
<script src="../admin/assets/js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="../admin/assets/demo/chart-area-demo.js"></script>
<script src="../admin/assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
<script src="../admin/assets/js/datatables-simple-demo.js"></script>
  <!-- SweetAlert CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="../admin/assets/js/custom.js"></script>
</body>
<script>
    // 
    // 
    const imageInput = document.getElementById('imageInput');
    const imageFrame = document.getElementById('imageFrame');

    imageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imageFrame.src = e.target.result;
                imageFrame.style.display = 'block';
            };

            reader.readAsDataURL(file);
        }
    });
    //
  
   
    function filterProductsByBrand() {
        var brandId = document.getElementById('brand_id').value;
        if (brandId) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_products.php?brand_id=" + brandId, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('products-table').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        } else {
            // Reset to all products if no brand is selected
            location.reload();
        }
    }


</script>

</html>