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
<<<<<<< HEAD
                    {{ in_array($data[0], $selected, false) ? 'selected' : '' }} />
=======
                    {{ in_array($data[0], $selected, false) ? 'checked' : '' }} />
>>>>>>> dc341214038bc7aabd893bac019c77e96156708a
                  {{ $data[1] }}
                </label>
              </div>
              @endforeach
              
            </div>