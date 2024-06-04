<?php
/**
 * Fungsi utama untuk menangani pengolahan data.
 * @param string $root parameter menu
 * @param object $conn mysqli connection
 */
function data_handler($root, $conn)
{
    if (isset($_GET['act']) && $_GET['act'] == 'add') {
        data_editor($root, $conn);
        return;
    }
    $sql = 'SELECT COUNT(*) AS total FROM social_media';
    $res = $conn->query($sql);
    if ($res->num_rows > 0) {
        if (isset($_GET['act']) && $_GET['act'] != '') {
            switch ($_GET['act']) {
                case 'edit':
                    if (isset($_GET['email']) ) {
                        data_editor($root, $conn, $_GET['email']);
                    } else {
                        show_admin_data($root, $conn);
                    }
                    break;
                case 'view':
                    if (isset($_GET['email'])) {
                        data_detail($root, $_GET['email'], $conn);
                    } else {
                        show_admin_data($root, $conn);
                    }
                    break;
                case 'del':
                    if (isset($_GET['email']) ) {
                        $id = $_GET['email'];
                        $sql = "DELETE FROM social_media WHERE email = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $id);
                        $stmt->execute();
                        if ($stmt->affected_rows > 0) {
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
    <h2 class="heading">Administrasi Data Sosial Media</h2>
    <!-- <a href="<?php echo $root; ?>&act=add">Tambah Data</a> -->
    <?php
    $sql = 'SELECT * FROM social_media';
    $res = $conn->query($sql);
    if ($res) {
        if ($res->num_rows > 0) {   
            ?>
        <div class="tabel">
        <table border=1 width=700 cellpadding=4 cellspacing=0>
          <tr>
            <th>nomor</th>
            <th width=120>email</th>
            <th width=120>telepon</th>
            <th width=120>alamat</th>

            <th>Menu</th>
          </tr>
          <?php
              $i = 1;
            while ($row = $res->fetch_assoc()) {
                $bg = (($i % 2) != 0) ? '' : 'even';
                $id = $row['email']; ?>
            <tr class="<?php echo $bg; ?>">
              <td width="2%"><?php echo $i; ?></td>
              <td>
                <a href="<?php echo $root; ?>&act=view&email=<?php echo $id; ?>" title="Lihat Data"><?php echo $id; ?></a>
              </td>

              <td><?php echo $row['telepon']; ?></td>
              <td><?php echo $row['alamat']; ?></td>

              <td align="center">
              | <a href="<?php echo $root; ?>&act=edit&email=<?php echo $id; ?>">Edit</a> |
              | <a href="<?php echo $root; ?>&act=del&email=<?php echo $id; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</a> |
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
              alamat <a href="'.$root.'&amp;act=add">di sini</a>';
        }
        $res->close();
    }
}

function data_detail($root, $id, $conn)
{
    $sql = 'SELECT * FROM social_media WHERE email=?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res) {
        if ($res->num_rows > 0) { ?>
        <div class="tabel">
        <table border=1 width=700 cellpadding=4 cellspacing=0>
          <?php
            $row = $res->fetch_assoc(); ?>
          <tr>
            <td>email</td>
            <td><?php echo $row['email']; ?></td>
          </tr>
          <tr>
            <td>telepon</td>
            <td><?php echo $row['telepon']; ?></td>
          </tr>
          <tr>
            <td>alamat</td>
            <td><?php echo $row['alamat']; ?></td>
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
    if (isset($_POST['email']) && $_POST['email']) {
        if (!$id) {
            // Lengkapi Pernyataan PHP SQL untuk INSERT data
            $sql = "INSERT INTO social_media (email, telepon, alamat) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss",$_POST['email'], $_POST['telepon'], $_POST['alamat']);
            $res = $stmt->execute();
            if ($res) { ?>
            <script type="text/javascript">
            document.location.href="<?php echo $root; ?>";
            </script>
            <?php
            $stmt->close();
            } else {
                echo 'Gagal menambah data';
            }
        } else{
            $sql = "UPDATE social_media SET email = ?, telepon = ?, alamat = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $_POST['email'], $_POST['telepon'], $_POST['alamat'], $id);
            $res = $stmt->execute();
        
            if ($res) {
                header('Location: ' . $root);
                exit;
            } else {
                echo 'Gagal memodifikasi';
            }
        }
    }
    // Menyiapkan data untuk updating
    if ($view) {
        if ($id) {
            $sql = 'SELECT * FROM social_media'.
                   ' WHERE email=?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res) {
                if ($res->num_rows > 0) {
                    $row = $res->fetch_assoc();
                    $email = $row['email'];
                    $telepon = $row['telepon'];
                    $alamat = $row['alamat'];

                } else {
                    show_admin_data($root, $conn);
                    return;
                }
            }
	         $res->close();


        } else {
            $email = @$_POST['email'];
            $telepon = @$_POST['telepon'];
            $alamat = @$_POST['alamat'];

        }
        ?>
      <h2> <?php echo $id ? 'Edit' : 'Tambah'; ?> Data</h2>
      <form action="" method="post">
      <table border=1 cellpadding=4 cellspacing=0>
      <tr>
        <td>email</td>
        <td> <input type="text" name="email" size=60 
             value="<?php echo $email; ?>" /> </td>
      </tr>
      <tr>
        <td>telepon</td>
        <td> <input type="text" name="telepon" size=60 
             value="<?php echo $telepon; ?>" /> </td>
      </tr>
      <tr>
        <td>alamat</td>
        <td> <input type="alamat" name="alamat" size=60 
             value="<?php echo $alamat; ?>" /> </td>
      </tr>
      <tr>
      <td> </td>
      <td><input type="submit" value="Submit" />
      <input type="button" value="Cancel" 
        onclick="history.go(-1)" /></td>
      </tr>
      </table>
      </form> <br />
    <?php
    }

    return false;
}
?>