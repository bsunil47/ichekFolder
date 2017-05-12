<div style="position:absolute;
     width:300px;
     height:200px;
     z-index:15;
     top:50%;
     left:50%;
     margin:-100px 0 0 -150px;
     background:gainsboro;">
    <form method="post" >
        <div style="font:bold; padding-bottom: 10px; padding-top: 10px; padding-left: 10px;">Change Password</div>
        <div style="padding-left: 50px;padding-bottom: 10px;">
            <label style="display: inline-block; width:150px">Password</label>
            <input name="password" type="text"/>
        </div>
        <div style="padding-left: 50px; padding-bottom: 10px;">
            <label style="display: inline-block; width:150px">Confirm Password</label>
            <input name="c_password" type="text"/>
        </div>
        <div style="padding-left: 50px;padding-bottom: 10px;">
            <input name="submit" type="submit"/>
        </div>

    </form>
    <div style="font:bold; padding-bottom: 10px;padding-left: 10px; color:<?php if (isset($error)) { ?>red<?php } else { ?>green<?php } ?>"    ><?php
        if (isset($error)) {
            echo $error;
        } else {
            echo $success;
        }
        ?></div>
</div>