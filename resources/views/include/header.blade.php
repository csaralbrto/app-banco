
<nav class="bg-blue-900 border-gray-200">
  <div class="flex w-full flex-wrap justify-between mx-auto p-4">
    <a href="{{ route('home') }}" class="flex text-left">
        <img src="{{ asset('images/bank.png') }}" class="h-8 mr-3" alt="App banco" />
        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">App Banco</span>
    </a>
    <div class="hidden w-full md:block md:w-auto" id="navbar-default">
      <ul class="flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg  md:flex-row md:space-x-8 md:mt-0 md:border-0">
        <li>
          <a href="{{ route('cuentas.index') }}"  class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-300 md:p-0">Cuentas</a>
        </li>
        <li>
          <a href="{{ route('reportes.index') }}" class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-300 md:p-0">Reportes</a>
        </li>
      </ul>
    </div>
</nav>