<x-guest-layout>
    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-1/12 bg-dots-darker bg-center bg-orange-50 selection:bg-red-500 selection:text-white">
        <div class="w-11/12 md:hidden lg:hidden">
            <a href="/">
                <img src='/landscape_logo_dotted.svg' alt="Logo" class="w-48 border border-red">
            </a>
        </div>
        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="font-semibold hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="font-semibold bg-white border border-black rounded-md px-4 py-2 md:mt-2 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                        in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="bg-white border border-black rounded-md px-4 py-2 ml-4 font-semibold focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
    <div class="flex flex-col lg:flex-row flex-nowrap">
        <div id="" class="w-full sticky top-4 bg-white">
            <div class="border-t-2 border-b-2 border-black flex flex-row flex-wrap py-2 mb-3 px-4 ">
                <a href="#about">
                    <div class="text-2xl">About</div>
                </a>
            </div>
        </div>
        <div id="" class="w-full p-1/12 flex flex-col flex-nowrap p-12">
            <div id="about">
                <h2 class=" text-3xl font-bold">What is Reteer?<span
                        class="px-2 text-orange-500 hover:text-black">#about</span></h2>
                <p class="p-3">Reteer is an open source application being designed to reduce organizational overhead
                    within volunteer organizations. It is designed for groups with extremely low budgets who rely on
                    donations and volunteer work to do good. The project is philosophically grounded in agile principles
                    and is, at its core, a partnership between:
                </p>
                <ul class="p-1 px-10 list-disc">
                    <li><em>Developers</em> who want to help people do good in their communities by contributing to the
                        established workflows of organizations comprised of mostly nontechnical volunteers by
                        <span>providing technical tools and automation to support volunteers</span>
                    </li>
                    <li><em>Volunteers</em> who have already established functional processes through experience in
                        their
                        domains and are willing to provide insight to contributing developers and to adminstrators about
                        how
                        technical solutions may improve their ability to help others in their community</li>
                    <li><em>Administrators</em> and employees of nonprofit organizations who (a) can benefit from
                        project
                        organization and task automation, especially in cases where the reduction of time allocation for
                        administrative tasks may be allocated towards the scope/scale of their organization's output and
                        (b)
                        are willing to advocate within their organization for more effective and compassionate
                        processes.
                    </li>
                </ul>
                <p class="p-3">The long-term mission of reteer is to provide custom-coded tools and features to
                    volunteer
                    organizations and support the optimization of workflows and the dedicated volunteers and
                    administrators
                    who advocate for them with data insights and reporting.
                </p>
            </div>
            <div>
                <h2 class=" text-3xl font-bold">Ok- But What Does It Do?</h2>
                <p class="p-3">As you may have gathered from this landing page, the application is
                    in very early stages and the <span>minimum viable product</span> currently being tested allows
                    volunteers to volunteer for tasks that need to be completed. The project is being used by a
                    volunteer
                    organization and the scope of the entire project is currently limited to one group of testers. New
                    features are being developed iteratively based on the success of these features and will be
                    announced as
                    they prove successful.
                </p>
            </div>
            <div>
                <h2 class=" text-3xl font-bold">My Organization Would Like To Use the App</h2>
                <p class="p-3">That's wonderful! After the first round of testing is resolved, a beta will be
                    announced and organizations can be added based on interest expressed by sigining up for the mailing
                    list. If you'd like to try out a demo to see the basic features of the app, you can do that by
                    signing
                    up to create a temporary organization and try it out.
                </p>
            </div>
            <div>
                <h2 class=" text-3xl font-bold">I Would Like To Contribute To Development</h2>
                <p class="p-3">Rad. And we're definitely going need your help. There's already a small group of
                    developers working on the application but because contribution guidelines and project principles
                    have
                    not been established, and because a clear workflow has not yet emerged from collaboration with the
                    testing organization, we can't accept and review pull requests currently.
                </p>
                <p class="p-3">The project is being developed in Laravel, so when we open contributions we'll be
                    looking
                    for developers who have experience with Laravel/PHP/JavaScript. There's almost certainly going to
                    beopportunity to expand functionality into different languages and domains as needs become apparent
                    but
                    the needs of the testing organization are too pressing to leave room for long-term decision making
                    at
                    this time.
                </p>
                <p class="p-3">If you're interested in getting more information, sign up for the developer mailing
                    list
                    or follow this project on social media. If you are a developer, we ask that you try out the features
                    via
                    a local installation. You can do that by forking the repository on github and following the
                    instructions
                    in the readme. Have ideas of how to improve the design or functionality of the app? Also rad. You
                    can
                    contact Mary Eleanor Perry at <a href="email:admin@reteer.org"
                        class="bg-orange-100 hover:bg-orange-200 hover:text-blue-800">admin@reteer.org</a> or reach out
                    on
                    the-app-formerly-known-as-twitter at <a href="https://x.com/sifrious"
                        class="bg-orange-100 hover:bg-orange-200 hover:text-blue-800">@sifrious</a>.
                </p>
            </div>
            <div>
                <h2 class="text-3xl font-bold">Principles of Contribution and Participation For Developers</h2>
                <p class="p-3">
                    While the project is not yet open for contribution, a few general principles may help you decide if
                    this
                    project will be a good fit for you:
                </p>
                <ul class="p-1 px-10 list-decimal">
                    <li>You are currently involved with or are willing to be involved with a volunteer organization that
                        has
                        little or no technical integration in its workflow or mission.<br><span>While organizations that
                            advocate for STEM education, open source projects and the inclusion of underrepresented
                            groups
                            in tech are wonderful, this project is aimed at providing techincal resources that work for
                            organizations that have the need for or willingness to incorporate technical administration
                            and
                            automation in non-technical domains.</span></li>
                    <li>You are curious about how to help people who are helping people and are willing to address
                        business
                        problems that wouldn't normally recieve technical support or adminstration because of budget
                        considerations. Your motivation for solving problems is more about getting the problem solved
                        than
                        recognition or compinsation. You want a chance to move fast and make an impact.
                    </li>
                    <li>You like the idea of 'random acts of kindness' and want to get outside your comfort zone to help
                        out. This can mean wanting to meet new people outside of your normal circles, a desire to
                        evaluate
                        and improve efficiency in cases where motive is not profit-driven, or anything in between.</li>
                </ul>
            </div>
            <div class="hidden">
                <h2 class="text-3xl font-bold">Philosophy: Agile and Open Source</h2>
                <p class="p-3">
                </p>
                <h3 class="text-xl font-bold p-1.5">What's "Agile"?</h3>
                <p class="p-3">
                </p>
                <h3 class="text-xl font-bold p-1.5">What's "Open Source"?</h3>
                <p class="p-3">
                </p>
            </div>
            <div class="hidden">
                <h2 class="text-3xl font-bold">Reteer on GitHub</h2>
                <p class="p-3">
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
