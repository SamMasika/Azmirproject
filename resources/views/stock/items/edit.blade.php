<div class="modal fade" id="EditModal{{$item['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" >Edit Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form action="{{url('item-update/'.$item['id'])}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="itemName-field" class="form-label">Item Name</label>
                        <input type="text" name="name" id="itemname-field" class="form-control" placeholder="Enter Name" required value="{{$item['name']}}" />
                    </div>

                   
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>