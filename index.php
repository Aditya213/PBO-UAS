<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Perkembangan Kambing</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Questrial&display=swap" rel="stylesheet">
</head>
<style>
    label {
        font-family: 'Questrial', sans-serif;
    }
</style>

<body style="background-color: #ade8f4;">
    <div class="container mt-5">
        <div class="card p-3" style="width: 80%;">
            <div class="card-body">
                <h3 style="font-family: 'Questrial';">Perkembangan Kambing</h3><br>
                <form id="formKambing" method="POST">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="input_nama_kambing" name="nama_kambing" required>
                                <label for="input_nama_kambing" class="form-label">Nama Kambing</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="input_berat_awal" name="berat_awal" placeholder="Berat Awal" min="0">
                                    <label for="input_berat_awal">Berat Awal</label>
                                </div>
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="input_tinggi_awal" name="tinggi_awal" placeholder="Tinggi Awal" min="0">
                                    <label for="input_tinggi_awal">Tinggi Awal</label>
                                </div>
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="input_panjang_awal" name="panjang_awal" placeholder="Panjang Awal" min="0">
                                    <label for="input_tinggi_awal">Panjang Awal</label>
                                </div>
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="input_perkembangan" name="perkembangan_bulanan" placeholder="Perkembangan Bulanan" min="0">
                                    <label for="input_perkembangan">Perkembangan Bulanan</label>
                                </div>
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-warning">Kirim Data</button>
                    </div>
                </form>
                <div class="row">
                    <div class="col-12 mt-3">
                        <hr>
                        <h4 style="font-family:'Questrial';" id="hasil_nama_peternak"></h4>
                        <b id="hasil_nama_kambing" style="font-family:'Questrial';"></b>
                    </div>
                    <div class="col-12 mt-3">
                        <span id="detailKambing"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>




</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $("#formKambing").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "process.php",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                $("#hasil_nama_peternak").html(response.result_nama_peternak);
                $("#hasil_nama_kambing").html(response.result_kambing_list[0].result_nama_kambing);

                var tableHtml = "<table class='table' border='1'><thead><tr class='table-warning'><th>Bulan</th><th>Berat</th><th>Tinggi</th><th>Panjang</th></tr></thead><tbody>";
                for (var month in response.result_kambing_list[0].perkembangan_list) {
                    var dataPerBulan = response.result_kambing_list[0].perkembangan_list[month];

                    tableHtml += "<tr>";
                    tableHtml += "<td>" + month + "</td>";
                    tableHtml += "<td>" + dataPerBulan.berat + " kg</td>";
                    tableHtml += "<td>" + dataPerBulan.tinggi + " cm</td>";
                    tableHtml += "<td>" + dataPerBulan.panjang + " cm</td>";
                    tableHtml += "</tr>";
                }

                tableHtml += "</tbody></table>";

                // Menampilkan tabel di elemen dengan ID "detailKambing"
                $("#detailKambing").html(tableHtml);
            }
        });
    });
</script>