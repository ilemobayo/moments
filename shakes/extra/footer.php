<!-- modal -->
<div id="mission" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-body">
        <img src="" id="john_wick_the_hacker" width="100%" height="auto">
    </div>
    <div id="post_actions_wick">
            <input type="hidden" name="name" value="<?php echo $username;?>">
            <p id="nums_like_wick" class="likes"></p>
        </div>
    </div>
    <div class="modal-footer">
        <table width="100%">          <tr>
            <td>
              <button class="btn btn-default btn-xm btn-block" aria-hidden="true" onclick="likeimg(<?php echo $enroll;?>);" ><i class="icon-heart icon-large"></i>Like</button>
            </td>
            <td>
              <a href="" id="downloadimg" download="photo"><button class="btn btn-success btn-xm btn-block" aria-hidden="true"><i class="icon-download icon-large"></i>Save</button></a>
            </td>
            <td>
            <button class="btn btn-primary btn-xm btn-block" data-dismiss="modal" aria-hidden="true"><i class="icon-remove-sign icon-large"></i>&nbsp;Close</button>
            </td>
          </tr>
        </table>
    </div>
  </div>
</div>
</div>
<!-- ends-->

</body>
</html>
