document.addEventListener("DOMContentLoaded",()=>{const d=document.getElementById("loading-skeleton"),n=document.getElementById("pd-non-aktif"),r=document.getElementById("no-data-alert");fetch("/pd/nonaktif",{method:"GET",headers:{Accept:"application/json"}}).then(e=>e.json()).then(e=>{const c=Array.isArray(e)?e:Object.values(e),s={};c.forEach(a=>{if(s[a.id]||(s[a.id]={...a,anggota_rombels:[]}),a.anggota_rombels){const l=Array.isArray(a.anggota_rombels)?a.anggota_rombels:[a.anggota_rombels];s[a.id].anggota_rombels.push(...l)}}),d.classList.add("hidden"),Object.keys(s).length===0?r.classList.remove("hidden"):(r.classList.add("hidden"),n.classList.remove("hidden"),n.innerHTML="",Object.values(s).forEach((a,l)=>{const i=[];a.anggota_rombels.forEach(o=>{i.find(x=>x.id===o.id)||i.push(o)});const m=o=>new Date(o).toLocaleDateString("id-ID",{day:"numeric",month:"long",year:"numeric"}),g=a.photo?`/storage/${a.photo}`:a.gender==="M"?"/storage/images/illustrasi/male.png":"/storage/images/illustrasi/female.png",p=a.is_alumni===1?'<span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Alumni</span>':'<span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Tidak Aktif</span>',h=a.reason||"Tidak ada alasan";let t=document.createElement("div");t.className=`
                        bg-white border border-gray-100 rounded-2xl shadow-md hover:shadow-xl 
                        transition transform hover:-translate-y-1 duration-300 overflow-hidden flex flex-col`,t.innerHTML=`
                        <div class="p-5 flex items-start">
                            <img src="${g}" alt="${a.name}" 
                                class="w-24 h-28 object-cover rounded-lg border border-gray-200 shadow-sm">
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">${a.name}</h3>
                                <p class="text-sm text-gray-500">No Induk: <span class="font-medium">${a.nis}</span></p>
                                <p class="text-sm text-gray-500">Tanggal Keluar: <span class="font-medium">${m(a.end_date)}</span></p>
                                <p class="text-sm text-gray-500">Alasan: <span class="font-medium">${h}</span></p>
                                <div class="mt-2 space-x-2">
                                    ${p}
                                    <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-700 rounded-full">
                                        Tahun: ${a.tahun_lulus}
                                    </span>
                                </div>
                               <p class="mt-2 text-sm text-gray-500 truncate max-w-[200px]"> ${a.email}</p>
                            </div>
                        </div>
                    `,n.appendChild(t)}))}).catch(e=>console.error("Error:",e))});
