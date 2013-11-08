jQuery.extend(jQuery.fn.fmatter , {
    date_hr : function(cellvalue, options, rowdata){
        if(null != cellvalue){
            var datetime = cellvalue.date;
            var date_clean = datetime.substring(0, 10);
            var n = date_clean.split('-');
            var date_hr = n[2]+'.'+n[1]+'.'+n[0];
            return date_hr;
        }
        return '';
    },
    datetime : function(cellvalue, options, rowdata) {
        if(null != cellvalue){
            return cellvalue.date;
        }
        return '';
    }
});