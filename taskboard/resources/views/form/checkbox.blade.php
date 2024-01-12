            <!--ラベル-->
            <div class="form-group">
              <label for="taskborad">{{ $label }}</label>

              <!--チェックボックス-->
              @foreach($datas as $data)
              <div class="form-check">
                <label class="form-check-label">
                  <input
                    type="checkbox"
                    class="form-check-input"
                    value="{{ $data[0] }}"
                    name="{{ $name  . '[]' }}" 
                    {{ in_array($data[0], $selected, false) ? 'selected' : '' }} />
                  {{ $data[1] }}
                </label>
              </div>
              @endforeach
              
            </div>