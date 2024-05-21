<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Todos</title>
</head>
<body>
      <table>
        @foreach ($todos as $todo )
          <tr>
              <td>{{ $todo->title }}</td>
              <td>
                    @can('update', $todo)
                        Edit
                    @else
                        No Edit    
                    @endcan

                    @can('delete', $todo)
                        Delete
                    @else
                        No Delete  
                    @endcan
              </td>
          </tr>
        @endforeach
      </table>
</body>
</html>