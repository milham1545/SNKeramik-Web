<?php
/**
 * Fungsi utama untuk menangani pengolahan data.
 * @param string root parameter menu
 * @param object conn mysqli connection
 */

function data_handler($root, $conn)
{
    if (isset($_GET['act']) && $_GET['act'] == 'add') {
        data_editor($root, $conn);
        return;
    }
    $sql = 'SELECT COUNT(*) AS total FROM produk';
    $res = $conn->query($sql);
    // Jika data di tabel ada
    if ($res->num_rows > 0) {
        if (isset($_GET['act']) && $_GET['act'] != '') {
            switch ($_GET['act']) {
                case 'edit':
          if (isset($_GET['id_produk']) && ctype_digit($_GET['id_produk'])) {
                        data_editor($root, $conn, $_GET['id_produk']);
                    } else {
                        show_admin_data($root, $conn);
                    }
                    break;
                case 'view':
        if (isset($_GET['id_produk']) && ctype_digit($_GET['id_produk'])) {
                        data_detail($root, $_GET['id_produk'], $conn);
                    } else {
                        show_admin_data($root, $conn);
                    }
                    break;
                case 'del':
                    if (isset($_GET['id_produk']) && ctype_digit($_GET['id_produk'])) {
                        $id = $_GET['id_produk'];
                        $sql = "DELETE FROM produk WHERE id_produk = $id";
                        $res = $conn->query($sql);
                        if ($res) {
                            header("Location: $root");
                            exit();
                        } else {
                            echo 'Gagal menghapus data';
                        }
                } else {
                    show_admin_data($root, $conn);
                    }
                    break;
                default:
                    show_admin_data($root, $conn);
            }
        } else {
            show_admin_data($root, $conn);
        }
        $res->close();
    } else {
        echo 'Data Tidak Ditemukan';
    }
}

function show_admin_data($root, $conn)
{ ?>
    <h2 class="heading">Administrasi Data Produk</h2>
    <h2>Nomor 1-4 adalah untuk halaman utama</h2>
    <h2>Nomor 1-5 adalah untuk produk</h2>
    <?php
    $sql = 'SELECT id_produk, gambar_produk,kategori, nama_produk, stok_produk, deskripsi_produk FROM produk';
    $res = $conn->query($sql);
    if ($res) {
        if ($res->num_rows > 0) {   
            ?>
        <div class="tabel">
          <div style="padding:5px;">
            <a href="<?php echo $root; ?>&amp;act=add">Tambah Data</a>
          </div>
        <table border=1 width=700 cellpadding=4 cellspacing=0>
          <tr>
            <th>nomor</th>
            <th width=120>id_produk</th>
            <th width=120>gambar_produk</th>
            <th width=120>kategori</th>
            <th width=200>nama_produk</th>
            <th width=200>stok_produk</th>
            <th width=200>deskripsi_produk</th>
            <th>Menu</th>
          </tr>
          <?php
              $i = 1;
            while ($row = $res->fetch_assoc()) {
                $bg = (($i % 2) != 0) ? '' : 'even';
                $id = $row['id_produk']; ?>
            <tr class="<?php echo $bg; ?>">
              <td width="2%"><?php echo $i; ?></td>
              <td>
                <a href="<?php echo $root; ?>&amp;act=view&amp;id_produk=<?php echo $id; ?>" title="Lihat Data"><?php echo $id; ?></a>
              </td>

              <td><img width ="100px"src="<?php echo $row['gambar_produk']; ?>"/></td>
              <td><?php echo $row['kategori']; ?></td>
              <td><?php echo $row['nama_produk']; ?></td>
              <td><?php echo $row['stok_produk']; ?></td>
              <td><?php echo $row['deskripsi_produk']; ?></td>
              <td align="center">
              | <a href="<?php echo $root; ?>&amp;act=edit&amp;id_produk=<?php echo $id; ?>">Edit</a> |
              | <a href="<?php echo $root; ?>&amp;act=del&amp;id_produk=<?php echo $id; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</a> |
            </td>
            </tr>
            <?php
                ++$i;
            }
            ?>
        </table>
        </div>
        <?php
        } else {
            echo 'Belum ada data, 
              isi <a href="'.$root.'&amp;act=add">di sini</a>';
        }
        $res->close();
    }
}
function data_detail($root, $id, $conn)
{
    $sql = 'SELECT id_produk, gambar_produk, kategori, nama_produk, stok_produk, deskripsi_produk FROM produk WHERE id_produk='.$id;
    $res = $conn->query($sql);
    if ($res) {
        if ($res->num_rows > 0) { ?>
        <div class="tabel">
        <table border=1 width=700 cellpadding=4 cellspacing=0>
          <?php
            $row = $res->fetch_assoc(); ?>
          <tr>
            <td>id_produk</td>
            <td><?php echo $row['id_produk']; ?></td>
          </tr>
          <tr>
            <td>gambar_produk</td>
            <td><?php echo $row['gambar_produk']; ?></td>
          </tr>
          <tr>
            <td>kategori</td>
            <td><?php echo $row['kategori']; ?></td>
          </tr>
          <tr>
            <td>nama_produk</td>
            <td><?php echo $row['nama_produk']; ?></td>
          </tr>
          <tr>
            <td>stok_produk</td>
            <td><?php echo $row['stok_produk']; ?></td>
          </tr>
          <tr>
            <td>deskripsi_produk</td>
            <td><?php echo $row['deskripsi_produk']; ?></td>
          </tr>
        </table>
        </div>
        <?php
        } else {
            echo 'Data Tidak Ditemukan';
        }
        $res->close();
    }
}

function data_editor($root, $conn, $id = 0)
{
    $view = true;
    if (isset($_POST['id_produk']) && $_POST['id_produk']) {
        // Jika tidak disertai id, berarti insert baru
        if (!$id) {
            $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . '/web_php/uploads/';
            $targetFile = $targetDirectory . basename($_FILES['gambar_produk']['name']);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if file is an actual image
            $check = getimagesize($_FILES['gambar_produk']['tmp_name']);       

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // If everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES['gambar_produk']['tmp_name'], $targetFile)) {
                    echo "The file ". htmlspecialchars( basename( $_FILES["gambar_produk"]["name"])). " has been uploaded.";

                    // Complete PHP SQL statement to INSERT data
                    $sql = "INSERT INTO produk (gambar_produk, kategori, nama_produk, stok_produk, deskripsi_produk) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $oo = "http://localhost/web_php/uploads/".$_FILES['gambar_produk']['name'];
                    $stmt->bind_param("sssss", $oo, $_POST['kategori'], $_POST['nama_produk'], $_POST['stok_produk'], $_POST['deskripsi_produk']);
                    $res = $stmt->execute();
                    if ($res) {
                        // Redirect to root page
                        header('Location: ' . $root);
                        exit;
                    } else {
                        echo 'Failed to add data';
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . '/web_php/uploads/';
            $targetFile = $targetDirectory . basename($_FILES['gambar_produk']['name']);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if file is an actual image
            $check = getimagesize($_FILES['gambar_produk']['tmp_name']);
            move_uploaded_file($_FILES['gambar_produk']['tmp_name'], $targetFile); 
            echo "The file ". htmlspecialchars( basename( $_FILES["gambar_produk"]["name"])). " has been uploaded.";   
            $sql = "UPDATE produk SET gambar_produk = ?, kategori = ?, nama_produk = ?, stok_produk = ?, deskripsi_produk = ? WHERE id_produk = ?";
            $stmt = $conn->prepare($sql);
            $oo = "http://localhost/web_php/uploads/".$_FILES['gambar_produk']['name'];

        
            // Buat variabel untuk menyimpan nilai $_POST
            $gambar_produk = $oo; // karena file gambar tidak diubah pada update
            $kategori = $_POST['kategori'];
            $nama_produk = $_POST['nama_produk'];
            $stok_produk = $_POST['stok_produk'];
            $deskripsi_produk = $_POST['deskripsi_produk'];
            $id_produk = $_POST['id_produk'];
        
            // Bind variabel-variabel tersebut ke dalam statement
            $stmt->bind_param("sssssi", $gambar_produk, $kategori, $nama_produk, $stok_produk, $deskripsi_produk, $id_produk);
            $res = $stmt->execute();
            $stmt->close();
        
            if ($res) {
                header('Location: ' . $root);
                exit;
            } else {
                echo 'Failed to modify data';
            }
        }
    }
    // Menyiapkan data untuk updating
    if ($view) {
        if ($id) {
            $sql = 'SELECT id_produk,gambar_produk, kategori, nama_produk, stok_produk,deskripsi_produk,id_produk FROM produk'.
                   ' WHERE id_produk='.$id;
            $res = $conn->query($sql);
            if ($res) {
                if ($res->num_rows > 0) {
                    $row = $res->fetch_assoc();
                    $id_produk = $row['id_produk'];
                    $gambar_produk = $row['gambar_produk'];
                    $kategori = $row['kategori'];
                    $nama_produk = $row['nama_produk'];
                    $stok_produk = $row['stok_produk'];
                    $deskripsi_produk = $row['deskripsi_produk'];

                } else {
                    show_admin_data($root, $conn);
                    return;
                }
            }
            $res->close();
        } else {
            $id_produk = @$_POST['id_produk'];
            $gambar_produk = @$_POST['gambar_produk'];
            $kategori = @$_POST['kategori'];
            $nama_produk = @$_POST['nama_produk'];
            $stok_produk = @$_POST['stok_produk'];
            $deskripsi_produk = @$_POST['deskripsi_produk'];
        }
        ?>
        <h2><?php echo $id ? 'Edit' : 'Tambah'; ?> Data</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <table border=1 cellpadding=4 cellspacing=0>
                <tr>
                    <td width=100>id_produk*</td>
                    <td> <input type="text" name="id_produk" size=10 placeholder="isi 0"
                        value="<?php echo $id_produk; ?>" /> </td>
                </tr>
                <tr>
                    <td width=100><h4>gambar_produk*(jangna lupa diisi)</h4></td>
                    <td> <input type="file" id="fileInput" name="gambar_produk"  accept="image/*" onchange="showFileName()"> 
                    </td> 
                </tr>
                <tr>
                    <td width=100>kategori*</td>
                    <td> <input type="text" name="kategori" size=10 
                        value="<?php echo $kategori; ?>" /> </td>
                </tr>
                <tr>
                    <td>nama_produk</td>
                    <td> <input type="text" name="nama_produk" size=40 
                        value="<?php echo $nama_produk; ?>" /> </td>
                </tr>
                <tr>
                    <td>stok_produk</td>
                    <td> <input type="text" name="stok_produk" size=60 
                        value="<?php echo $stok_produk; ?>" /> </td>
                </tr>
                <tr>
                    <td>deskripsi_produk</td>
                    <td> <input type="text" name="deskripsi_produk" size=60 
                        value="<?php echo $deskripsi_produk; ?>" /> </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Submit" />
                    <input type="button" value="Cancel" 
                        onclick="history.go(-1)" /></td>
                </tr>
            </table>
        </form> <br />
        <p>Ket: * Harus diisi</p>
    <?php
    }
    return false;
}
