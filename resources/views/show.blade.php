<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    </head>
    <body class="antialiased">
        <h1>Participant Lists</h1>  
        
        <div class="row">
            <div class="col-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add participant</button>
            </div>
            
            <div class="col-10">
                <span>Show only register with notes</span>
                <input id="note-toggle" onchange="refreshShow()" type="checkbox" @php if($checked) echo "checked"; @endphp>
            </div>
        </div>
        
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Note</th>
                <th scope="col">Option</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($participants as $participant)
                    <tr id="colum-id-{{$participant->id}}">
                        <th scope="row">{{$participant->id}}</th>
                        <td id="row-{{$participant->id}}-col-fname" >{{$participant->fName}}</td>
                        <td id="row-{{$participant->id}}-col-lname">{{$participant->lName}}</td>
                        <td id="row-{{$participant->id}}-col-phone">{{$participant->phone}}</td>
                        <td id="row-{{$participant->id}}-col-note">{{$participant->note}}</td>
                        <td>
                            <button type="button" onclick="updateRegisterLoad({{$participant->id}})" data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-primary">Edit</button>
                        </td>
                        <td>
                            <button type="button" onclick="deleteRegister({{$participant->id}})" class="btn btn-danger">X</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
            <div class="modal-dialog">
                <form id = "modal-form" onsubmit="addRegister()">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Participant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">First Name:</label>
                                <input type="text" class="form-control" id="first-name" required>
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Last Name:</label>
                                <input type="text" class="form-control" id="last-name" required>
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Phone number:</label>
                                <input type="number" class="form-control" id="phone">
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Note:</label>
                                <textarea class="form-control" id="note"></textarea>
                            </div>
                                
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
            <div class="modal-dialog">
                <form id = "edit-modal-form" onsubmit="updateRegister()">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Participant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">ID:</label>
                                <input type="text" class="form-control" id="idLabel" disabled >
                            </div>
                            
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">First Name:</label>
                                <input type="text" class="form-control" id="edit-first-name" required>
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Last Name:</label>
                                <input type="text" class="form-control" id="edit-last-name" required>
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Phone number:</label>
                                <input type="number" class="form-control" id="edit-phone">
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Note:</label>
                                <textarea class="form-control" id="edit-note"></textarea>
                            </div>
                                
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" onclick="updateRegister({{$participant->id}})">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{ $participants->links() }}

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ URL::asset('js/participantClientController.js') }}"></script>
        <a hidden href="{{ route('create') }}" id="addRegisterURL"></a>
        <a hidden href="{{ route('delete') }}" id="deleteRegisterURL"></a>
        <a hidden href="{{ route('get') }}" id="getRegisterURL"></a>
        <a hidden href="{{ route('update') }}" id="updateRegisterURL"></a>
        <a hidden href="{{ route('show') }}" id="showURL"></a>

    </body>
</html>
