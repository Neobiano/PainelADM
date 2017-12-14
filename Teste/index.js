$(function(){
    var dataGrid = $("#gridContainer").dxDataGrid({
        dataSource: customers,
		showRowLines : true, 
		showBorders : true, 
		
		//rowAlternationEnabled : true,
        
		allowColumnReordering: true,
		
		filterRow: { visible: true },
	
		
        grouping: {
            autoExpandAll: true,
        },
        searchPanel: {
            visible: true
        },
        paging: {
            pageSize: 10
        },  
        groupPanel: {
            visible: true
        },
        columns: [
			"ID",
            "CompanyName",
            "Phone",
            "Fax",
            "City",
			"State",
			{
			  dataField: "productID",
			  dataType: "string",
			  cellTemplate: function(container, options) {				

				container.append($("<a  href=\'resources/" + options.value + "'>Sei La Fi</a>"));
			  }
			}
        ],	
		onCellPrepared: function (e) {
            if (e.rowType == 'data') {
                if ((e.column.dataField == 'ID') ) 
                {
                    //e.cellElement.addClass(css( "color", "red" ));
                  e.cellElement.addClass("cls"+"Green");                   
                }
            }
        },  
		onRowPrepared: function (info) {
					if (info.rowType != "header" )
						info.rowElement.addClass("clsRed");
				},  
		summary: {
            groupItems: [{
                column: "State",
                summaryType: "count",
                displayFormat: "{0} Registros",
				
		}]}
    }).dxDataGrid("instance");
    
    $("#autoExpand").dxCheckBox({
        value: true,
        text: "Expand All Groups",
        onValueChanged: function(data) {
            dataGrid.option("grouping.autoExpandAll", data.value);
        }
    });
});