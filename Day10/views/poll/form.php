<h3>Bạn muốn cải thiện điều gì trên website?</h3>
<form action="index.php?act=poll_vote" method="POST">
  <label><input type="radio" name="option" value="Giao diện"> Giao diện</label><br>
  <label><input type="radio" name="option" value="Tốc độ"> Tốc độ</label><br>
  <label><input type="radio" name="option" value="Dịch vụ khách hàng"> Dịch vụ khách hàng</label><br>
  <button type="submit"> bình chọn</button>
</form>



<div id="pollResult"></div>

<script>
document.getElementById('pollForm').addEventListener('submit', function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch('index.php?act=poll_vote', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            loadPollResult();
        } else {
            alert(data.message);
        }
    });
});

function loadPollResult(){
    fetch('index.php?act=poll_result')
    .then(res => res.json())
    .then(data => {
        let html = '<h4>Kết quả bình chọn:</h4><ul>';
        for(let key in data){
            html += `<li>${key}: ${data[key]}%</li>`;
        }
        html += '</ul>';
        document.getElementById('pollResult').innerHTML = html;
    });
}

loadPollResult();
</script>
