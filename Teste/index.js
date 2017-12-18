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
			  dataField: "ID",
			  width : 100,
			  dataType: "string",
			  cellTemplate: function(container, options) {
    		        var productName = options.value;
    		        $("<a href=\'?m=tipos&t=incluir&id=" + options.value + "' title='Novo'><img src='images/add.png' alt='Novo cadastro' /></a>  <a href=\'?m=tipos&t=editar&id=" + options.value + "' title='Editar'><img src='images/edit.png' alt='Editar'/></a> <a href=\'?m=tipos&t=excluir&id=" + options.value + "'><img src='images/delete.png' alt='Excluir' /></a>")		      		       
    		        .appendTo(container);
    		       // container.append($("<a  href=\'?m=tipos&t=editar&id=" + options.value + "'><img src=images/delete.png /></a>"));
    		      }
			}
        ],	
		onCellPrepared: function (e) {
            if (e.rowType == 'data') {
                if (e.column.dataField == 'CompanyName')  
                {                   
                  e.cellElement.addClass("cls"+"Green");                   
                }
				else if (e.column.dataField == 'ID')  
                {                  
                  e.cellElement.addClass("clsWhite");  					
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