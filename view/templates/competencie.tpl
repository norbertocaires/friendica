<div>{{$competencie.name}}</div>
<div>{{$competencie.statement}}</div>
<div class="profile-edit-side-div">
    <a class="icon edit" title="{{$edit}}" href="{{$competencie.edit}}" >
    </a>
    <form id="form1" name="form1" action="{{$competencie.del}}" method="post" >
     <!--   <input class="icon delete" id="event-submit" type="submit" name="submit" value="$del" /> -->
        <button class="icon delete" href="" onclick="document.getElementById('form1').submit();" >
    </form>
    </a>
</div>
<br/>
<hr/>