$(document).ready(function(){
    var html ='<tr><td><div class="form-floating mb-3"><input class="form-control" type="text" name="candidatename[]" id="candidatename" required><label for="candidatename">Candidate Name</label></div></td><td><div class="form-floating mb-3"><textarea class="form-control" type="text" name="candidatedesc[]" id="candidatedesc" style="height: 200px;" required></textarea><label for="candidatedesc">Candidate Description</label></div></td><td><div class="mb-3"><input class="form-control" type="file" name="candidateimage[]" id="candidateimage" required></div></td><td><button class="btn btn-danger" type="button" name="removecandidate" id="removecandidate">Remove Candidate</button></td></tr>';

    var min = 2;
    var x = 2;

    $("#addcandidate").click(function(){
        $("#candidatefield").append(html);
        x++;
    })

    $("#candidatefield").on('click', '#removecandidate', function(){
        if(x>min){
            $(this).closest('tr').remove();
            x--;
        }

    })

})
