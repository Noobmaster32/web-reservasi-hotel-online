<!-- Index HTML -->
<?php

$conn = mysqli_connect("localhost", "root", "", "db_hotel_online");

function query($query)
{
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}


function cariToList($keyword)
{
    $query = "SELECT * FROM hotel where desc_hotel LIKE '%$keyword%'";
    return query($query);
}

function listHotels($result)
{
    $no = 0;

    while (isset($result[$no]) && $row = ($result[$no])) {
        echo "<div class='w-full mb-4 shadow-lg rounded-lg overflow-auto'>
        <a href='./hotel.php?nama=$row[nama]'>
                <div class='flex h-60'>
                    <div class='basis-2/6 h-full bg-slate-500'>
                        <img class='w-full h-full object-cover' src='./images/image-$row[id].webp' alt='$row[nama]' />
                    </div>
                    <div class='basis-3/6 h-full bg-white'>
                        <div class='p-4'>
                            <h1 class='text-2xl font-semibold'>$row[nama]</h1>
                        </div>
                    </div>
                    <div class='basis-1/6 h-full bg-slate-50'>
                        <div class='flex flex-col gap-2 h-full justify-center items-center'>
                            <div class='text-xl'>Bintang</div>
                            <div class='text-5xl'>$row[bintang]</div>
                        </div>
                    </div>
                </div>
            </a>
    </div>";
        $no++;
    }
}

function inputDescHotel($desc, $checkin, $checkout, $count)
{
    echo "<form class='flex justify-around' action='./page/hotelList.php' method='post'>
            <div class='grow'>
                <div>
                    <label for='keyword'>Negara, Kota, Destinasi, atau Alamat</label>
                </div>
                <div>
                    <input class='w-full' type='text' id='keyword' name='keyword' value='$desc' disabled>
                </div>
            </div>
            <div class='grow'>
                <div>
                    <label for='checkin'>Check In</label>
                </div>
                <div>
                    <input class='w-full' type='date' id='checkin' name='checkin' value='$checkin' disabled>
                </div>
            </div>
            <div class='grow'>
                <div>
                    <label for='checkout'>Check Out</label>
                </div>
                <div>
                    <input class='w-full' type='date' id='checkout' name='checkout' value='$checkout' disabled>
                </div>
            </div>
            <div class='grow'>
                <div>
                    <label for='count'>Jumlah</label>
                </div>
                <div>
                    <input class='w-full' type='text' id='count' name='count' value='$count' disabled>
                </div>
            </div>
            </form>";
}


// Fungsi Login
function login($username, $password)
{
    global $conn;

    $query = "SELECT * FROM user WHERE username='$username' OR email='$username'";
    $result = mysqli_query($conn, $query);


    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        if ($row['user_password'] == $password) {
            $_SESSION["login"] = true;
            setcookie("nama_depan", $row["nama_depan"]);
            setcookie("nama_belakang", $row["nama_belakang"]);
            setcookie("email", $row["email"]);
            header("Location: ./index.php");
            exit;
        }
    }

    $error = true;
}

function transferCookie($desc, $checkin, $checkout, $count)
{
    global $conn;

    $query = "SELECT * FROM hotel where desc_hotel LIKE '%$desc%'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        setcookie("desc", $desc);
        setcookie("checkin", $checkin);
        setcookie("checkout", $checkout);
        setcookie("count", $count);
    } else {
        header("Location: ./index.php");
    }
}

function typeHotelList($id)
{
    global $conn;
    $queryHotel = "SELECT * FROM hotel where id=$id";
    $query = "SELECT * FROM kamar where id_hotel=$id";

    $resultHotel = mysqli_query($conn, $queryHotel);
    $dataHotel = mysqli_fetch_array($resultHotel);
    

    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_array($result)) {
            if (isset($_POST['book'])) {
                setcookie('typeRoom', $_POST['book']);
                setcookie('nama_hotel', $dataHotel['nama']);
                header('Location: ./pembayaran.php');
            }
            echo "<div class='w-full bg-white mb-4 shadow-lg rounded-lg overflow-auto '>
                <div class= 'm-4 text-4xl font-bold pl-2' >$data[jenis]</div>
                <div class='flex m-4 rounded-lg overflow-auto border-black border-2'>
                    <div class='basis-3/12'>
                        <img src='./images/image$data[jenis].webp' alt='$data[jenis]'>
                    </div>
                    <div class='basis-6/12'>
                        <div class='p-4 flex flex-col h-full justify-center'>
                            <p class='text-xl '>Fasilitas yang Diberikan:</p>
                            $data[fasilitas]
                        </div>
                    </div>
                    <div class='basis-3/12'>
                        <div class='p-4 flex flex-col h-full justify-center items-center'>
                            <div class='text-2xl mb-4'>
                                Rp. $data[harga].00
                            </div>
                            <form method='post'>
                                <button class='bg-black hover:shadow-xl text-white font-medium rounded-md px-4 py-2' type='submit' name='book' id='book' value='$data[jenis]'>Book Now!</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>";
        }
    }
}

function formPembayaran($checkin, $checkout, $nama_hotel, $jenis_kamar, $jumlah, $email)
{
    global $conn;

    $queryUser="SELECT * FROM user WHERE email='$email'";
    $query="SELECT * FROM hotel WHERE nama='$nama_hotel'";
    $resultUser = mysqli_query($conn, $queryUser);
    $resultHotel = mysqli_query($conn, $query);
    $dataHotel = mysqli_fetch_array($resultHotel);
    $dataUser = mysqli_fetch_array($resultUser);
    $queryHargaKamar = "SELECT harga FROM kamar WHERE id_hotel='$dataHotel[id]' AND jenis='$jenis_kamar'";
    $resultHargaKamar = mysqli_query($conn, $queryHargaKamar);
    $dataHargaKamar = mysqli_fetch_array($resultHargaKamar);
    $kamar_per_malam = ((strtotime($checkout)-strtotime($checkin))/(60*60*24)) * $dataHargaKamar['harga'];
    $total_harga = $kamar_per_malam*$jumlah;

    if (isset($_POST["agree"])) {
        $query = "INSERT INTO pemesanan (id, id_user, id_hotel, banyak_pemesanan, check_in, check_out, jenis_kamar, harga_kamar_per_malam, harga_sewa_kamar, total_harga) VALUES ('', '$dataUser[id]', '$dataHotel[id]', '$jumlah', '$checkin', '$checkout', '$jenis_kamar', '$dataHargaKamar[harga]', '$kamar_per_malam', '$total_harga')";
        $hasil = mysqli_query($conn, $query);
        if ($hasil) {
            setcookie("typeRoom","");
            setcookie("count","");
            setcookie("checkin","");
            setcookie("checkout","");
            setcookie("desc","");
            setcookie("nama_hotel","");
            header("Location: ./index.php");
        } else {
            echo "Data Gagal Ditambahkan";
        }
    }

    if(isset($_POST["edit"])) {
        header("Location: ./editPembayaran.php");
    }

    echo "<form method='post' class='flex flex-col gap-2'>
            <div>
                <div><label class='text-lg font-medium' for=''>Nama Depan</label></div>
                <div><input type='text' value='$dataUser[nama_depan]'/></div>
            </div>
            <div>
                <div><label class='text-lg font-medium' for=''>Nama Belakang</label></div>
                <div><input type='text' value='$dataUser[nama_belakang]'/></div>
            </div>
            <div>
                <div><label class='text-lg font-medium' for=''>Check In</label></div>
                <div><input type='date' value='$checkin'/></div>
            </div>
            <div>
                <div><label class='text-lg font-medium' for=''>Check Out</label></div>
                <div><input type='date' value='$checkout'/></div>
            </div>
            <div>
                <div><label class='text-lg font-medium' for=''>Nama Hotel</label></div>
                <div>$nama_hotel</div>
            </div>
            <div>
                <div><label class='text-lg font-medium' for=''>Jenis Hotel</label></div>
                <div><input type='text' value='$jenis_kamar'/></div>
            </div>
            <div>
                <div><label class='text-lg font-medium' for=''>Banyak Kamar yang Disewa</label></div>
                <div><input type='text' value='$jumlah'/></div>
            </div>
            <div>
                <div><label class='text-lg font-medium' for=''>Harga Kamar per Malam</label></div>
                <div>".$dataHargaKamar['harga']."</div>
            </div>
            <div>
                <div><label class='text-lg font-medium' for=''>Harga Per Kamar</label></div>
                <div>".$kamar_per_malam."</div>
            </div>
            <br/>
            <div>
                <div><label class='text-lg font-medium' for=''>Total Harga</label></div>
                <div>".$total_harga."</div>
            </div>

            <div class='flex gap-4'>
                <button class='bg-[#4983D9] grow mt-8 mb-16 p-4 rounded-md text-xl font-medium text-white hover:opacity-50 shadow-md' type='submit' name='agree' id='agree'>Setuju Pembelian</button>
                <button class='bg-white grow mt-8 mb-16 p-4 rounded-md text-xl font-medium text-[#4983D9] hover:brightness-50 shadow-md border-[#4983D9] border-2' type='submit' name='edit' id='edit'>Edit Pembelian</button>
            </div>
        </form>";
    
}

function editPemesanan($checkin, $checkout, $jumlah){
    if(isset($_POST["setuju"])) {
        setcookie('checkin',$_POST['editcheckin']);
        setcookie('checkout',$_POST['editcheckout']);
        setcookie('count',$_POST['editcount']);
        header('Location: ./pembayaran.php');
    }
    if(isset($_POST["batalkan"])) {
        header('Location: ./pembayaran.php');
    }
    echo "<form method='post'>
        <div>
            <div><label class='text-lg font-medium' for='editcheckin'>Check In</label></div>
            <div><input type='date' name='editcheckin' id='editcheckin' value='$checkin'/></div>
        </div>
        <div>
            <div><label class='text-lg font-medium' for='editcheckout'>Check Out</label></div>
            <div><input type='date' name='editcheckout' id='editcheckout' value='$checkout'/></div>
        </div>
        <div>
            <div><label class='text-lg font-medium' for='editcount'>Banyak Kamar yang Disewa</label></div>
            <div><input type='text' name='editcount' id='editcount' value='$jumlah'/></div>
        </div>
        <div class='flex gap-4'>
                <button class='bg-[#4983D9] grow mt-8 mb-16 p-4 rounded-md text-xl font-medium text-white hover:opacity-50 shadow-md' type='submit' name='setuju' id='setuju'>Setuju Perubahan</button>
                <button class='bg-white grow mt-8 mb-16 p-4 rounded-md text-xl font-medium text-[#4983D9] hover:brightness-50 shadow-md border-[#4983D9] border-2' type='submit' name='batalkan' id='batalkan'>Batalkan Perubahan</button>
        </div>
    </form>";
}

function historyPemesanan($email) {
    global $conn;

    $queryUser = "SELECT * FROM user WHERE email='$email'";
    $resultUser = mysqli_query($conn, $queryUser);
    $dataUser = mysqli_fetch_array($resultUser);
    $queryPemesanan = "SELECT * FROM pemesanan WHERE id_user = '$dataUser[id]'";
    $resultPemesanan = mysqli_query($conn, $queryPemesanan);

    while ($dataPemesanan = mysqli_fetch_array($resultPemesanan)) {
        $queryHotel = "SELECT * FROM hotel WHERE id='$dataPemesanan[id_hotel]'";
        $resultHotel = mysqli_query($conn, $queryHotel);
        $dataHotel = mysqli_fetch_array($resultHotel);
        echo "<div class='shadow-lg w-full mb-2 rounded-lg flex bg-white'>
            <div class='w-full py-4 px-8'>
                <div class='flex justify-between mb-2 mt-4'>
                    <div class='basis-1/2'>
                        <div class='text-lg'>Nama Lengkap</div>
                        $dataUser[nama_depan] $dataUser[nama_belakang]
                    </div>
                    <div class='basis-1/2 flex justify-between'>
                        <div>
                            <div class='text-lg flex flex-col items-start'>Check In</div>
                            $dataPemesanan[check_in]
                        </div>
                        <div>
                            <div class='text-lg flex flex-col items-end'>Check Out</div>
                            $dataPemesanan[check_out]
                        </div>
                    </div>
                </div>
                <hr/>
                <div class='flex justify-between my-2'>
                    <div>
                        <div class='text-lg'>Nama Hotel</div>
                        $dataHotel[nama]
                    </div>
                    <div class='flex flex-col items-center'>
                        <div class='text-lg '>Harga Kamar per Malam</div>
                        <div class=''>$dataPemesanan[harga_kamar_per_malam]</div>
                    </div>
                    <div class='flex flex-col items-end'>
                        <div class='text-lg'>Jenis Hotel</div>
                        <div class=''> $dataPemesanan[jenis_kamar] </div>
                    </div>
                </div>
                <hr/>
                <div class='flex justify-between items-center'>
                    <div class='mt-2'>
                        <div class='text-lg'>Harga Sewa Kamar</div>
                        <div class=''>$dataPemesanan[harga_sewa_kamar]</div>
                    </div>
                    X
                    <div class='mt-2 flex flex-col items-center'>
                        <div class='text-lg '>Jumlah Kamar Disewa</div>
                        <div class=''>$dataPemesanan[banyak_pemesanan]</div>
                    </div>
                    =
                    <div class='mt-2 flex flex-col items-end'>
                        <div class='text-lg'>Total Harga</div>
                        <div class=''>$dataPemesanan[total_harga]</div>
                    </div>
                </div>
                <div class='w-full flex flex-row-reverse my-2 pr-16 gap-4 box-border'>
                    <a class='text-sm text-slate-700 ' href='./deleteHist.php?id=$dataPemesanan[id]'>Hapus History</a>
                    <a class='text-sm text-slate-700 ' href='./editHistory.php?id=$dataPemesanan[id]'>Edit History</a>
                </div>
            </div>
        </div>";
    }
}

function editHistory($id) {
    global $conn;

    $query = "SELECT * FROM pemesanan WHERE id=$id";
    $result = mysqli_query($conn, $query);

    while($data = mysqli_fetch_array($result)) {
    if(isset($_POST["setujuperubahan"])) {
        $checkout = $_POST["editcheckouthistori"];
        $checkin = $_POST["editcheckinhistori"];
        $count =$_POST["editcounthistori"];

        $hargasewakamar = ((strtotime($checkout) - strtotime($checkin))/(60*60*24)) * $data['harga_kamar_per_malam'];
        $total_harga = $hargasewakamar * $count;
        $query = "UPDATE pemesanan SET check_in='$checkin', check_out='$checkout', banyak_pemesanan='$count', harga_sewa_kamar='$hargasewakamar', total_harga='$total_harga' WHERE id='$id'";
        $result = mysqli_query($conn, $query);
        if($result){
            header("Location: ./histpembayaran.php");
        } else {
            echo "Data Gagal Ditambahkan";
        }
    }
    
    if(isset($_POST["batalkanperubahan"])) {
        header("Location: ./histpembayaran.php");
    }

    echo "<form method='post'>
        <div>
            <div><label class='text-lg font-medium' for='editcheckinhistori'>Check In</label></div>
            <div><input type='date' name='editcheckinhistori' id='editcheckinhistori' value='$data[check_in]'/></div>
        </div>
        <div>
            <div><label class='text-lg font-medium' for='editcheckouthistori'>Check Out</label></div>
            <div><input type='date' name='editcheckouthistori' id='editcheckouthistori' value='$data[check_out]'/></div>
        </div>
        <div>
            <div><label class='text-lg font-medium' for='editcounthistori'>Banyak Kamar yang Disewa</label></div>
            <div><input type='text' name='editcounthistori' id='editcounthistori' value='$data[banyak_pemesanan]'/></div>
        </div>
        <div class='flex gap-4'>
                <button class='bg-[#4983D9] grow mt-8 mb-16 p-4 rounded-md text-xl font-medium text-white hover:opacity-50 shadow-md' type='submit' name='setujuperubahan' id='setujuperubahan'>Setuju Perubahan Histori</button>
                <button class='bg-white grow mt-8 mb-16 p-4 rounded-md text-xl font-medium text-[#4983D9] hover:brightness-50 shadow-md border-[#4983D9] border-2' type='submit' name='batalkanperubahan' id='batalkanperubahan'>Batalkan Perubahan Histori</button>
        </div>
    </form>";
    }

}
?>