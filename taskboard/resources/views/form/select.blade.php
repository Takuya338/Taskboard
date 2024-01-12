            <!--ラベル-->
            <div class="form-group">
              <label for="taskborad">{{ $label }}</label>
              
              <select class="form-control" name="{{ $name }}">
                @if(isset($selected))
                  <option value="0">選択してください</option>
                @else
                  <option value="0" selected>選択してください</option>
                @endif  
                @foraeach($datas as $data)
                  @if($selected == $data[0])
                    <option value="{{ $data[0] }}" selected>{{ $data[1] }}</option>
                  @else
                    <option value="{{ $data[0] }}">{{ $data[1] }}</option>
                  @endif
                @endforeach
              </select>
            </div>