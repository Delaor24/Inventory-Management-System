class Notification{
    success(){
        new Noty({
            type:'success',
            layout:'topRight',
            text: 'Successfully Done',
            timeout:1000,
         }).show();
    }

    addTocart(){
        new Noty({
            type:'success',
            layout:'topRight',
            text: 'Cart Added Successfully',
            timeout:1000,
        }).show();
    }
    cartRemove(){
        new Noty({
            type:'error',
            layout:'topRight',
            text: 'Cart Removed',
            timeout:1000,
        }).show();
    }

    increment(){
        new Noty({
            type:'success',
            layout:'topRight',
            text: 'Cart Increment',
            timeout:1000,
        }).show();
    }

    decrement(){
        new Noty({
            type:'success',
            layout:'topRight',
            text: 'Cart Decrement',
            timeout:1000,
        }).show();
    }

    alert(){
        new Noty({
            type:'alert',
            layout:'topRight',
            text: 'Are you sure ?',
            timeout:1000,
        }).show();
    }

    error(){
        new Noty({
            type:'error',
            layout:'topRight',
            text: 'Data Deleted!',
            timeout:1000,
        }).show();
    }

    warning(){
        new Noty({
            type:'warning',
            layout:'topRight',
            text: 'Oops ! Wrong ',
            timeout:1000,
        }).show();
    }
    imageValidation(){
        new Noty({
            type:'warning',
            layout:'topRight',
            text: 'Image File, less then 1 MB',
            timeout:2000,
        }).show();
    }


}
export default Notification = new Notification();
