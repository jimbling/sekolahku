document.addEventListener("DOMContentLoaded",()=>{const m=document.getElementById("loading-skeleton"),r=document.getElementById("pd-non-aktif"),d=document.getElementById("no-data-alert");fetch("/pd/nonaktif",{method:"GET",headers:{Accept:"application/json"}}).then(t=>t.json()).then(t=>{const c=Array.isArray(t)?t:Object.values(t),o={};c.forEach(e=>{if(o[e.id]||(o[e.id]={...e,anggota_rombels:[]}),e.anggota_rombels){const n=Array.isArray(e.anggota_rombels)?e.anggota_rombels:[e.anggota_rombels];o[e.id].anggota_rombels.push(...n)}}),m.classList.add("hidden"),Object.keys(o).length===0?d.classList.remove("hidden"):(d.classList.add("hidden"),r.classList.remove("hidden"),r.innerHTML="",Object.values(o).forEach((e,n)=>{const i=[];e.anggota_rombels.forEach(a=>{i.find(s=>s.id===a.id)||i.push(a)});let l=document.createElement("div");const g=a=>{const s=a.match(/Kelas (\d+)/);return s?s[1]:a};e.is_active&&i.map(a=>g(a.rombel.classroom.name)).join(", ");let p=e.photo?`/storage/${e.photo}`:e.gender==="M"?"/storage/images/illustrasi/male.png":"/storage/images/illustrasi/female.png";const x=a=>{const s={day:"numeric",month:"long",year:"numeric"};return new Date(a).toLocaleDateString("id-ID",s)};let f=e.is_alumni===1?'<span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Alumni</span>':`<span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Tidak Aktif: ${e.reason||"Tidak ada alasan"}</span>`;l.className="bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden flex flex-col",l.setAttribute("data-aos","fade-up"),l.setAttribute("data-aos-delay",`${n*100}`),l.innerHTML=`
                    <div class="p-4 flex flex-1 items-start">
                        <div class="flex-shrink-0">
                            <img src="${p}" alt="${e.name}" class="w-24 h-42 object-cover rounded-md border border-gray-300">
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">${e.name}</h3>
                            <p class="mt-1 text-sm text-gray-500">No Induk Siswa: ${e.nis}</p>
                            <p class="mt-1 text-sm text-gray-500">Tanggal Keluar: ${x(e.end_date)}  </p>
                            <p class="mt-1 text-sm text-gray-500">Alasan Keluar: ${e.reason}</p>
                           <p class="mt-1 text-sm text-gray-500">
                                Status: ${f}
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full">
                                    Tahun: ${e.tahun_lulus}
                                </span>
                            </p>
                            <p class="mt-1 text-sm text-gray-500">Email: ${e.email}</p>
                        </div>
                    </div>
                `,r.appendChild(l)}))}).catch(t=>{console.error("Error:",t)})});
