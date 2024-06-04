<?php
/**
 * Fungsi utama untuk menangani pengolahan data.
 * @param string $root parameter menu
 * @param object $conn mysqli connection
 */

function data_handler($root, $conn)
{
    if (isset($_GET['act'])) {
        switch ($_GET['act']) {
            case 'add':
                data_editor($root, $conn);
                return;
            case 'edit':
                if (isset($_GET['id_komentar']) && ctype_digit($_GET['id_komentar'])) {
                    data_editor($root, $conn, $_GET['id_komentar']);
                } else {
                    show_admin_data($root, $conn);
                }
                break;
            case 'del':
                if (isset($_GET['id_komentar']) && ctype_digit($_GET['id_komentar'])) {
                    $id = $_GET['id_komentar'];
                    $sql = "DELETE FROM tabel_keterhubungan WHERE id_komentar = $id";
                    $res = $conn->query($sql);
                    if ($res) {
                        header("Location: $root");
                        if (isset($_GET['id_balas']) && ctype_digit($_GET['id_balas'])) {
                            $ids = $_GET['id_balas'];
                            $sqls = "DELETE FROM balas WHERE id_balas = $ids";
                            $ress = $conn->query($sqls);
                            if ($ress) {
                                header("Location: $root");
                                exit();
                            } else {
                                echo 'Gagal menghapus data';
                            }
                        }
                    } 
                    
                } else {
                    show_admin_data($root, $conn);
                }
                break;
                case 'del_':
                    if (isset($_GET['id_komentar']) && ctype_digit($_GET['id_komentar'])) {
                        $id = $_GET['id_komentar'];
                        $sql = "DELETE FROM tabel_komentar WHERE id_komentar = $id";
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
}

function show_admin_data($root, $conn)
{
    ?>
    <h2 class="heading">Administrasi Data Komentar</h2>
    <?php
    $sql = "SELECT * FROM tabel_komentar";
    $res = $conn->query($sql);

    if ($res) {
        if ($res->num_rows > 0) {
            ?>
            <div class="tabel">
                <table border=1 width=700 cellpadding=4 cellspacing=0>
                    <tr>
                        <th>nomor</th>
                        <th width=120>id_komentar</th>
                        <th width=120>email</th>
                        <th width=120>nama</th>
                        <th width=200>isi</th>
                        <th width=200>balas_komentar</th>
                        <th>Menu</th>
                    </tr>
                    <?php
                    $i = 1;
                    while ($row = $res->fetch_assoc()) {
                        $bg = (($i % 2) != 0) ? '' : 'even';
                        $id = $row['id_komentar']; ?>
                        <tr class="<?php echo $bg; ?>">
                            <td width="2%"><?php echo $i; ?></td>
                            <td>
                                <a href="<?php echo $root; ?>&amp;act=view&amp;id_komentar=<?php echo $id; ?>"
                                   title="Lihat Data"><?php echo $id; ?></a>
                            </td>

                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['isi']; ?></td>
                            <td>
                                <?php
                                $sqls = "SELECT * FROM tabel_keterhubungan WHERE id_komentar = ". $row["id_komentar"];
                                $ress = $conn->query($sqls);
                                while ($rowsd = $ress->fetch_assoc()) {
                                    $ids = $rowsd['id_balas'];
                                    $sql_balas = "SELECT * FROM balas WHERE id_balas=".$rowsd["id_balas"];
                                    $res_balas = $conn->query($sql_balas);
                                    while($row_balas = $res_balas->fetch_assoc()) {
                                        echo $row_balas["balas_komentar"];
                                    }
                                }
                                ?>
                            </td>

                            <td align="center">
                                | <a href="<?php echo $root; ?>&amp;act=edit&amp;id_komentar=<?php echo $id; ?>">Balas</a> |
                                | <a href="<?php echo $root; ?>&amp;act=del&amp;id_komentar=<?php echo $id; ?>&amp;id_balas=<?php echo $ids; ?>"
                                    onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus Balasan</a> |
                                | <a href="<?php echo $root; ?>&amp;act=del_&amp;id_komentar=<?php echo $id; ?>"
                                    onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus Komentar</a> |
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
            echo 'Belum ada data, isi <a href="' . $root . '&amp;act=add">di sini</a>';
        }
        $res->close();
    }
}

function data_detail($root, $id, $conn)
{
    $sql = "SELECT * FROM tabel_komentar WHERE id_komentar=" . $id;
    $res = $conn->query($sql);
    if ($res) {
        if ($res->num_rows > 0) { ?>
            <div class="tabel">
                <table border=1 width=700 cellpadding=4 cellspacing=0>
                    <?php
                    $row = $res->fetch_assoc(); ?>
                    <tr>
                        <td>id_komentar</td>
                        <td><?php echo $row['id_komentar']; ?></td>
                    </tr>
                    <tr>
                        <td>email</td>
                        <td><?php echo $row['email']; ?></td>
                    </tr>
                    <tr>
                        <td>nama</td>
                        <td><?php echo $row['nama']; ?></td>
                    </tr>
                    <tr>
                        <td>isi</td>
                        <td><?php echo $row['isi']; ?></td>
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
    if (isset($_POST['id_komentar'])) {
        $id_komentar = $_POST['id_komentar'];
        $balas_komentar = $_POST['balas_komentar'];

        // Lakukan operasi INSERT ke tabel keterhubungan
        $sql = "INSERT INTO balas (balas_komentar) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s",$balas_komentar);
        $res = $stmt->execute();
        if($res) {
            $data = $conn->query("SELECT * FROM balas
            ORDER BY id_balas DESC
            LIMIT 1;
            ");
            $sqls = "INSERT INTO tabel_keterhubungan (id_komentar, id_balas) VALUES (?, ?)";
            $stmts = $conn->prepare($sqls);
            $stmts->bind_param("ii", $id_komentar,$data->fetch_assoc()["id_balas"]);
            $ress = $stmts->execute();
        }
        $stmt->close();


        $stmts->close();

        if ($res) {
            // Redirect kembali ke halaman utama setelah berhasil memasukkan data
            header("Location: $root");
            exit();
        } else {
            echo 'Gagal menambah data ke tabel keterhubungan';
        }
    }

    if ($id) {
        // // Ambil data komentar yang akan dibalas
        // $sql = "SELECT * FROM `tabel_keterhubungan` where id_balas=". $id;
        // $res = $conn->query($sql);
        // if ($res->num_rows > 0) {
        //     $row = $res->fetch_assoc();
        //     // $id_komentar = $row['id_komentar'];
        //     $id_balas = $row['id_balas'];
        //     $balas_komentar = $row['balas_komentar'];
            ?>
            <h2>Balas Komentar</h2>
            <form action="" method="post">
                <input type="hidden" name="id_komentar" value="<?= $_GET["id_komentar"] ?>">
                <table border=1 cellpadding=4 cellspacing=0>
                    <tr>
                        <td width=100>balas_komentar</td>
                        <td> <input type="text" name="balas_komentar" size=10 value="" /> </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Submit" />
                            <input type="button" value="Cancel" onclick="history.go(-1)" /></td>
                    </tr>
                </table>
            </form>
            <br />
            <?php
      
        // $res->close();
    }
}
