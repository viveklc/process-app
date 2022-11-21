 <!-- The Modal -->
 <div class="modal fade" id="add_user_modal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Assign User</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form action="{{ route('admin.team.user.add') }}" method="POST">
            @csrf
            <input type="hidden" name="org_id" value="1">
            <input type="hidden" name="team_id" value="{{ $id }}">
            <div class="form-group">
                <select name="user_id[]" id="user_id" class="form-control" multiple>
                    {{-- <option value="">--select user --</option> --}}
                        @forelse ($addTouser as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @empty

                        @endforelse
                </select>
            </div>
            <div class="form-group row">
                <button type="submit" id="kt_modal_new_ticket_submit" class="btn btn-primary">
                    <span class="indicator-label"> {{ trans('global.save') }}</span>
                </button>
            </div>

          </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
