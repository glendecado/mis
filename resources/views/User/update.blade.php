   <button type="button" @click="$dispatch('open-modal',  'Update Profile')"> Update profile </button>

   <x-modal name="Update Profile">
       <div>
           <form wire:submit.prevent="updateProfile">
               <div>
                   <label for="img">Profile Image</label>
                   <input type="file" wire:model="img" id="img">
                   @error('img') <span class="text-danger">{{ $message }}</span> @enderror
               </div>
               <div>
                   <label for="name">Name</label>
                   <input type="text" wire:model="name" id="name">
                   @error('name') <span class="text-danger">{{ $message }}</span> @enderror
               </div>
               <div>
                   <label for="email">Email</label>
                   <input type="email" wire:model="email" id="email">
                   @error('email') <span class="text-danger">{{ $message }}</span> @enderror
               </div>
               <div>
                   <label for="password">Password</label>
                   <input type="password" wire:model="password" id="password">
                   @error('password') <span class="text-danger">{{ $message }}</span> @enderror
               </div>
               <div>
                   <label for="password_confirmation">Confirm Password</label>
                   <input type="password" wire:model="password_confirmation" id="password_confirmation">
                   @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
               </div>
               <button type="submit">Update Profile</button>
           </form>
       </div>
   </x-modal>