function bindGrid(data) {
           $("#gridContainer").dxDataGrid({
                dataSource: data,
                columns: [
                    'id',
                    'nome'
                ],
                paging: {
                    pageSize: 200
                },
                sorting: {
                    mode: "multiple"
                },
                filterRow: {
                    visible: true
                },
                allowColumnReordering: true,
                allowColumnResizing: true,
                groupPanel: {
                    visible: true
                },
                selection: {
                    mode: "no"
                }
            });
} 
$(document).ready(function () {
    var hr = new XMLHttpRequest();
    hr.open("GET", "connsql.php", true);
    hr.setRequestHeader("Content-type", "application/json");
    hr.onreadystatechange = function() {
        if (hr.readyState == 4 && hr.status == 200) {
            var data = JSON.parse(hr.responseText);
            bindGrid(data.tipos);
        }
     }
     hr.send();      
});