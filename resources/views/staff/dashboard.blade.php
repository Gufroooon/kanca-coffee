<x-staff-layout>
    <div class="space-y-8" x-data="staffClockApp()">
        <!-- Live Clock & Shift Header -->
        <div class="glass-card dark:glass-dark rounded-3xl p-6 sm:p-8 border border-gray-200 dark:border-zinc-800 shadow-xl flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="space-y-1 text-center md:text-left">
                <span class="px-3 py-1 rounded-full bg-kanca-teal/10 text-kanca-teal font-extrabold text-[10px] uppercase tracking-wider">
                    Assigned Shift: {{ $user->shift }}
                </span>
                <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">Welcome back, {{ $user->name }}</h2>
                <p class="text-xs text-gray-500">Barista & Store Operations Station</p>
            </div>

            <!-- Digital Clock Display -->
            <div class="bg-zinc-900 text-white px-8 py-4 rounded-2xl shadow-inner text-center">
                <span class="block text-xs text-kanca-orange font-bold uppercase tracking-widest" x-text="currentDate"></span>
                <span class="text-3xl sm:text-4xl font-extrabold font-mono text-white" x-text="currentTime">00:00:00</span>
            </div>
        </div>

        <!-- Attendance Action Widget -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Today Status & Clock Buttons -->
            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-200 dark:border-zinc-800 shadow-lg space-y-6">
                <div class="flex justify-between items-center pb-4 border-b border-gray-100 dark:border-zinc-800">
                    <h3 class="font-bold text-base text-gray-900 dark:text-white">Today's Shift Attendance</h3>
                    @if($todayAttendance)
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $todayAttendance->status === 'late' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                            Status: {{ $todayAttendance->status }}
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 uppercase">Not Clocked In Yet</span>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="p-4 rounded-2xl bg-gray-50 dark:bg-zinc-800 border border-gray-100 dark:border-zinc-700">
                        <span class="text-[10px] text-gray-400 font-bold uppercase block">Clock In</span>
                        <span class="text-xl font-extrabold text-emerald-600">{{ $todayAttendance ? ($todayAttendance->clock_in ?? '-') : '-' }}</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-gray-50 dark:bg-zinc-800 border border-gray-100 dark:border-zinc-700">
                        <span class="text-[10px] text-gray-400 font-bold uppercase block">Clock Out</span>
                        <span class="text-xl font-extrabold text-rose-600">{{ $todayAttendance ? ($todayAttendance->clock_out ?? '-') : '-' }}</span>
                    </div>
                </div>

                <!-- Clock In / Clock Out Forms -->
                @if(!$todayAttendance)
                    <form action="{{ route('staff.attendance.clock-in') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="text" name="notes" placeholder="Optional Clock In Note (e.g. Traffic info)..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                        <button type="submit" class="w-full py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm transition-all shadow-xl shadow-emerald-600/20">
                            🟢 CLOCK IN NOW
                        </button>
                    </form>
                @elseif(!$todayAttendance->clock_out)
                    <form action="{{ route('staff.attendance.clock-out') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="text" name="notes" placeholder="Optional Clock Out Note..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                        <button type="submit" class="w-full py-4 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-sm transition-all shadow-xl shadow-rose-600/20">
                            🔴 CLOCK OUT NOW
                        </button>
                    </form>
                @else
                    <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-800 text-xs font-bold text-center">
                        ✓ Shift Completed For Today! Have a great rest.
                    </div>
                @endif
            </div>

            <!-- Quick Shift Guidelines & Location Tracker -->
            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-200 dark:border-zinc-800 shadow-lg space-y-4">
                <h3 class="font-bold text-base text-gray-900 dark:text-white">Barista Operational Guidelines</h3>
                <ul class="space-y-2 text-xs text-gray-600 dark:text-gray-400">
                    <li class="flex items-center gap-2">✓ <span>Clock in at least 10 minutes prior to espresso bar opening.</span></li>
                    <li class="flex items-center gap-2">✓ <span>Verify bean grinder calibration & water pressure.</span></li>
                    <li class="flex items-center gap-2">✓ <span>Location coordinates automatically validated upon submit.</span></li>
                </ul>

                <div class="pt-4 border-t border-gray-100 dark:border-zinc-800 text-xs text-gray-400">
                    <strong>Current GPS Location:</strong> Kanca Store Main Bar (-6.2297, 106.8080)
                </div>
            </div>
        </div>

        <!-- Monthly Attendance History -->
        <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-200 dark:border-zinc-800 shadow-lg space-y-4">
            <h3 class="font-bold text-base text-gray-900 dark:text-white">Monthly Shift Attendance Logs</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 uppercase font-bold">
                        <tr>
                            <th class="p-3">Date</th>
                            <th class="p-3">Clock In</th>
                            <th class="p-3">Clock Out</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($monthlyHistory as $log)
                            <tr>
                                <td class="p-3 font-bold">{{ $log->date ? $log->date->format('d M Y') : '' }}</td>
                                <td class="p-3 font-semibold text-emerald-600">{{ $log->clock_in ?? '-' }}</td>
                                <td class="p-3 font-semibold text-rose-600">{{ $log->clock_out ?? '-' }}</td>
                                <td class="p-3">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $log->status === 'late' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                        {{ $log->status }}
                                    </span>
                                </td>
                                <td class="p-3 text-gray-500">{{ $log->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-400">No shift records for this month.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function staffClockApp() {
            return {
                currentTime: '',
                currentDate: '',
                init() {
                    const update = () => {
                        const now = new Date();
                        this.currentTime = now.toLocaleTimeString('en-US', { hour12: false });
                        this.currentDate = now.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
                    };
                    update();
                    setInterval(update, 1000);
                }
            }
        }
    </script>
</x-staff-layout>
