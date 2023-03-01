<div class="row">
    <div class="col-md-12 table-responsive">
        <style>
            input[type=time] {
                width: 70px !important;
            }
            .date input[type=text] {
                width: 70px !important;
            }
           .form-control{
                padding:0;
            }
        </style>
        <table class="table display table-bordered table-striped table-hover bg-white m-0 card-table">
        <?php
        $id = (isset($emp)) ? $emp : 0;
        $date  = (!isset($date)) ? $date :  str_replace("/", "-", $date);
        $dat = explode("-", $date);
        $month =  ($dat[1] > 10) ? $dat[1] : "0".$dat[1];
        $date = $dat[0]."-".$month;
        $sql = "select * from prayer_time  where date like  '%$date%'";
        $r = DB::select($sql);
        $dr= array();
        $rc = array();
        foreach($r as $k=>$v){
            $dr[$v->date] = $v;
            $rc[] = (Array)$v;
        }
        $c = array_column($rc, "date");
        $m = (is_numeric(date("m"))) ? date("m") : (int) date("m");
        $days = cal_days_in_month(CAL_GREGORIAN, (int)$month,(int) $dat[0]);
    ?>
            <thead>
                <tr class="text-center">
                    <th>DAte</th>
                    <th>Day</th>
                    <th colspan="3">Fajar</th>
                    <th colspan="2">Zohar</th>
                    <th colspan="2">Asar</th>
                    <th colspan="2">Maghrib</th>
                    <th colspan="2">Isha</th>
                    <th>Action</th>
                </tr>
                <tr class="text-center">
                    <th></th>
                    <th></th>
                    <th>Begins</th>
                    <th>Iqamah</th>
                    <th>Sunrise</th>
                    <th>Begins</th>
                    <th>Iqamah</th>
                    <th>Begins</th>
                    <th>Iqamah</th>
                    <th>Begins</th>
                    <th>Iqamah</th>
                    <th>Begins</th>
                    <th>Iqamah</th>
                    <th></th>
                </tr>
                <?php for($n=1; $n<=$days; $n++){
                    $nday = (strlen($n) == 2) ? $n : "0$n";
                    $nmonth = (strlen($month)==2) ? $month : "0$month";
                    $ndate = "$year-$nmonth-$nday";
                    if (in_array($ndate, $c)){
                            $r = $dr[$ndate];
                            if (is_numeric($r->f_begins)){
                                $date = date("d/m/Y",strtotime($r->date));
                                  $day = date("D",strtotime($r->date));
                                $f_begins = date("h:i A",$r->f_begins);
                                $f_iqamah = date("h:i A",$r->f_iqamah);
                                $sunrise = date("h:i A",$r->sunrise);
                                $z_begins = date("h:i A",$r->z_begins);
                                $z_iqamah = date("h:i A",$r->z_iqamah);
                                $a_begins = date("h:i A",$r->a_begins);
                                $a_iqamah = date("h:i A",$r->a_iqamah);
                                $m_begins = date("h:i A",$r->m_begins);
                                $m_iqamah = date("h:i A",$r->m_iqamah);
                                $i_begins = date("h:i A",$r->i_begins);
                                $i_iqamah = date("h:i A",$r->i_iqamah);
                            }else{

                            }
                        }else{
                            $date = $nday."/$nmonth/$year";
                            $day = date("D",strtotime("$year/$nmonth/".$nday));
                            $f_begins = "";
                            $f_iqamah = "";
                            $sunrise= "";
                            $z_begins = "";
                            $z_iqamah = "";
                            $a_begins = "";
                            $a_iqamah = "";
                            $m_begins = "";
                            $m_iqamah = "";
                            $i_begins = "";
                            $i_iqamah = "";
                        }
                ?>
                    <tr class="text-center">
                    <td> <div class="date">{{ $date }}</div></td>
                    <td><div class="day">{{ $day }}</div></td>
                    <td><div class="f_begins">{{ $f_begins }}</div></td>
                    <td><div class="f_iqamah">{{ $f_iqamah }}</div></td>
                    <td><div class="sunrise">{{ $sunrise }}</div></td>
                    <td><div class="z_begins">{{ $z_begins }}</div></td>
                    <td><div class="z_iqamah">{{ $z_iqamah }}</div></td>
                    <td><div class="a_begins">{{ $a_begins }}</div></td>
                    <td><div class="a_iqamah">{{ $a_iqamah }}</div></td>
                    <td><div class="m_begins">{{ $m_begins }}</div></td>
                    <td><div class="m_iqamah">{{ $m_iqamah }}</div></td>
                    <td><div class="i_begins">{{ $i_begins }}</div></td>
                    <td><div class="i_iqamah">{{ $i_iqamah }}</div></td>
                    <td><a class="btn btn-primary editTime" href="#"> Edit</a></td>
                </tr>
                <?php } ?>
            </thead>
            <tbody>
            </tbody>
        </table>
        <br>
    </div>
</div>