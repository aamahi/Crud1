<?php
define("DB_NAME","/opt/lampp/htdocs/phpcode/data.txt");
function seed(){
    $data=array(
        array(
            "id"=>1,
            "fname"=>"Kamal",
            "lname"=>"Ahmed",
            "roll"=>"6"
        ),
        array(
            "id"=>2,
            "fname"=>"Rafiq",
            "lname"=>"Islam",
            "roll"=>"3"
        ),
        array(
            "id"=>3,
            "fname"=>"Nikhel",
            "lname"=>"Chandro",
            "roll"=>"10"
        ),
        array(
            "id"=>4,
            "fname"=>"Tareq",
            "lname"=>"hasan",
            "roll"=>"11"
        ),
        array(
            "id"=>5,
            "fname"=>"Akash",
            "lname"=>"Islam",
            "roll"=>"07"
        ),
        array(
            "id"=>6,
            "fname"=>"Robin",
            "lname"=>"hossin",
            "roll"=>"9"
        ),
    );
    $serialzeData=serialize($data);
    file_put_contents(DB_NAME,$serialzeData,LOCK_EX);
}
function genarateReport(){
    $serialzeData = file_get_contents(DB_NAME);
    $students = unserialize($serialzeData);
    ?>
    <table>
        <tr>
            <th>Name</th>
            <th>Roll</th>
            <th width='25%'>Action</th>
        </tr>
        <?php
        foreach($students as $student){
        ?>
        <tr>
            <td><?php printf("%s %s ",$student['fname'],$student['lname']); ?></td>
            <td><?php printf("%s ",$student['roll']); ?></td>
            <td><?php printf('<a href="/crud/index.php?task=edit&id=%s">Edit</a> | <a href="/crud/index.php?task=delete&id=%s" class="delete">Delete</a> ',$student['id'],$student['id']);?></td>
        </tr>
        <?php
        }
        
        ?>
    </table>
    <?php
}
function addStudent($fname,$lname,$roll){
    $found=false;
    $serialzeData = file_get_contents(DB_NAME);
    $students     = unserialize($serialzeData);
    foreach($students as $_student){
        if($_student['roll']==$roll){
            $found=true;
            break;
        }
    }
    if(!$found){
    $newId        = getNewId($students);
    $student      = array(
        "id"    =>$newId,
        "fname" => $fname,
        "lname" => $lname,
        "roll"  => $roll
    );
    array_push($students,$student);
    $serialzeData=serialize($students);
    file_put_contents(DB_NAME,$serialzeData,LOCK_EX);
    return true;
    }
return false;
}
function getStudent($id){
    $serialzeData = file_get_contents(DB_NAME);
    $students     = unserialize($serialzeData);
    foreach($students as $student){
        if($student['id']==$id){
            return $student;
        }
    }
    return false;
}
function updateStudent($id,$fname,$lname,$roll){
    $found=false;
    $serialzeData = file_get_contents(DB_NAME);
    $students     = unserialize($serialzeData);
    foreach($students as $_student){
        if($_student['roll']==$roll && $_student['id']!=$id){
            $found=true;
            break;
        }
    }
    if(!$found){
    $students[$id-1]['fname'] = $fname;
    $students[$id-1]['lname'] = $lname;
    $students[$id-1]['roll']  = $roll;
    $serialzeData             = serialize($students);
    file_put_contents(DB_NAME,$serialzeData,LOCK_EX);
    return true;
}
return false;
}
function deleteStudent($id){
    $serialzeData = file_get_contents(DB_NAME);
    $students     = unserialize($serialzeData);
    foreach($students as $offset=>$student){
        if($student['id']==$id){
            unset($students[$offset]);
        }
    }
    
    $serialzeData = serialize($students);
    file_put_contents(DB_NAME,$serialzeData,LOCK_EX);
}
function printRaw(){
    $serialzeData = file_get_contents(DB_NAME);
    $students     = unserialize($serialzeData);
    print_r($students);
}
function getNewId($students){
    $maxId = max(array_column($students,'id'));
    return $maxId+1;
}

?>