<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo /></x-slot>

        <div class="flex flex-col items-center justify-end mt-4">
            <p class="text-center p-4">
                This application is currently in the testing stage and is only open to invited users. Please contact
                <a href="mail:admin@reteer.org">admin@reteer.org</a>
                for access to the demo version or to discuss weather reteer is a good fit for your organization.
            </p>
            <a class="underline text-lg font-bold text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
