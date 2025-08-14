document.addEventListener("DOMContentLoaded",function(){const p=document.getElementById("gtk-skeleton"),d=document.getElementById("gtk-container"),u=document.getElementById("pagination-controls"),f=document.getElementById("gtk-search"),v=document.getElementById("gtk-filter");let x=1,o="",i="";function c(e=1,t="",l=""){if(isNaN(e)||e<1)return;let n=`/api/gtk?page=${e}`;t&&(n+=`&search=${encodeURIComponent(t)}`),l&&(n+=`&status=${encodeURIComponent(l)}`),fetch(n).then(s=>s.json()).then(s=>{if(p.style.display="none",d.innerHTML="",s.data.length===0){d.innerHTML=`
        <div class="col-span-full py-12 text-center">
            <div class="mx-auto w-24 h-24 text-gray-400 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-700">Tidak ada data ditemukan</h3>
            <p class="mt-1 text-gray-500">Coba gunakan kata kunci atau filter yang berbeda</p>
        </div>
    `,u.innerHTML="";return}s.data.forEach(a=>{const r=a.gtk_status==="Aktif",m=document.createElement("div");m.className=`bg-white rounded-lg overflow-hidden shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-1 ${r?"":"opacity-80"}`,m.innerHTML=`
                    <div class="relative">
                        <div class="${r?"bg-gradient-to-r from-blue-50 to-blue-100":"bg-gradient-to-r from-gray-100 to-gray-200"} h-32 flex justify-center items-end relative">
                            <div class="absolute top-2 right-2">
                                <span class="${r?"bg-green-500 text-white":"bg-gray-400 text-gray-800"} text-xs px-2 py-1 rounded-full font-medium">
                                    ${a.gtk_status}
                                </span>
                            </div>
                            <img src="${g(a)}" alt="Foto ${a.full_name}" 
                                class="absolute -bottom-12 w-24 h-24 rounded-full object-cover border-4 border-white shadow-md">
                        </div>
                    </div>
                    <div class="pt-16 pb-6 px-4 text-center space-y-2">
                        <h3 class="text-lg font-semibold ${r?"text-gray-800":"text-gray-500"}">${a.full_name}</h3>
                        <p class="text-sm ${r?"text-blue-600":"text-gray-400"}">${a.jabatan||"GTK"}</p>
                        <div class="mt-4 flex justify-center gap-2">
                            <button class="px-4 py-2 ${r?"bg-blue-600 hover:bg-blue-700":"bg-gray-400 hover:bg-gray-500"} text-white text-sm font-medium rounded-full transition-all duration-200 transform hover:scale-105 active:scale-95"
                                data-modal-id="${a.id}">
                                Lihat Detail
                            </button>
                           
                        </div>
                    </div>
                `,d.appendChild(m)}),b(),w(s)}).catch(s=>{console.error("Error:",s),d.innerHTML=`
                <div class="col-span-full py-12 text-center">
                    <div class="mx-auto w-24 h-24 text-red-400 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-700">Terjadi kesalahan</h3>
                    <p class="mt-1 text-gray-500">Gagal memuat data GTK. Silakan coba lagi.</p>
                    <button onclick="fetchGTKData(currentPage, currentSearch, currentStatus)" 
                        class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                        Muat Ulang
                    </button>
                </div>
            `})}function g(e){return e.photo?"/storage/"+e.photo:e.gender==="F"?"/storage/images/illustrasi/gtk-wanita.jpg":e.gender==="M"?"/storage/images/illustrasi/gtk-pria.jpg":"https://ui-avatars.com/api/?name="+encodeURIComponent(e.full_name)+"&background=random"}function b(){document.querySelectorAll("[data-modal-id]").forEach(t=>{t.addEventListener("click",()=>y(t.dataset.modalId))})}function y(e){fetch(`/api/gtk/${e}`).then(t=>t.json()).then(t=>{const l=t.gtk_status==="Aktif";let n=document.querySelector(`#modal-${e}`);n||(n=document.createElement("dialog"),n.id=`modal-${e}`,n.className="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm p-4 opacity-0 invisible transition-opacity duration-300",n.innerHTML=`
                    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95">
                        <div class="relative">
                            <button class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-white shadow-md flex items-center justify-center text-gray-500 hover:text-gray-700 transition-colors duration-200"
                                onclick="this.closest('dialog').close()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div class="grid md:grid-cols-2 gap-8 p-6">
                                <div class="space-y-6">
                                    <div class="flex items-center space-x-4">
                                        <img src="${g(t)}" alt="Foto ${t.full_name}" 
                                            class="w-24 h-24 rounded-full object-cover border-4 ${l?"border-blue-100":"border-gray-200"} shadow-md">
                                        <div>
                                            <h2 class="text-2xl font-bold ${l?"text-gray-800":"text-gray-500"}">${t.full_name}</h2>
                                            <p class="${l?"text-blue-600":"text-gray-400"} font-medium">${t.jabatan||"GTK"} • ${t.gtk_status}</p>
                                           
                                        </div>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="border-t border-gray-100 pt-4">
                                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Informasi Pribadi</h3>
                                            <div class="space-y-3">
                                                <div class="flex">
                                                    <span class="w-32 text-gray-500">Jenis Kelamin</span>
                                                    <span class="text-gray-700">${t.gender==="M"?"Laki-laki":"Perempuan"}</span>
                                                </div>
                                                <div class="flex">
                                                    <span class="w-32 text-gray-500">Status</span>
                                                    <span class="${l?"text-green-600":"text-gray-500"} font-medium">${t.gtk_status}</span>
                                                </div>
                                                <div class="flex">
                                                    <span class="w-32 text-gray-500">Status Induk</span>
                                                    <span class="text-gray-700">${t.parent_school_status===1?"INDUK":"NON INDUK"}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-6 flex flex-col items-center justify-center">
                                    <img src="${g(t)}" alt="Foto ${t.full_name}" 
                                        class="max-h-64 rounded-lg object-cover shadow-sm mb-4">
                                    <div class="text-center">
                                        <div class="inline-flex items-center px-4 py-2 rounded-full ${l?"bg-green-100 text-green-800":"bg-gray-100 text-gray-800"}">
                                            <span class="text-sm font-medium">Status: ${t.gtk_status}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `,document.body.appendChild(n)),n.showModal(),setTimeout(()=>{n.classList.remove("opacity-0","invisible"),n.querySelector("div").classList.remove("scale-95")},10),n.addEventListener("close",()=>{n.classList.add("opacity-0","invisible"),n.querySelector("div").classList.add("scale-95")})}).catch(t=>{console.error("Error fetching GTK detail:",t),alert("Gagal memuat detail GTK. Silakan coba lagi.")})}function w(e){u.innerHTML="";const t=document.createElement("div");if(t.className="flex items-center space-x-2",e.prev_page_url){const a=document.createElement("button");a.className="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors duration-200",a.innerHTML=`
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
        `,a.onclick=()=>c(e.current_page-1,o,i),t.appendChild(a)}const l=Math.max(1,e.current_page-2),n=Math.min(e.last_page,e.current_page+2);for(let a=l;a<=n;a++){const r=document.createElement("button");r.className=`w-10 h-10 flex items-center justify-center rounded-full transition-colors duration-200 ${a===e.current_page?"bg-blue-600 text-white":"bg-white border border-gray-200 text-gray-600 hover:bg-gray-50"}`,r.textContent=a,r.onclick=()=>c(a,o,i),t.appendChild(r)}if(e.next_page_url){const a=document.createElement("button");a.className="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors duration-200",a.innerHTML=`
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        `,a.onclick=()=>c(e.current_page+1,o,i),t.appendChild(a)}const s=document.createElement("div");s.className="text-sm text-gray-500 ml-4",s.textContent=`Menampilkan ${e.from||0}-${e.to||0} dari ${e.total} GTK`,u.appendChild(s),u.appendChild(t)}let h;f.addEventListener("input",e=>{clearTimeout(h),o=e.target.value.trim(),p.style.display="grid",d.innerHTML="",h=setTimeout(()=>{c(1,o,i)},800)}),v.addEventListener("change",()=>{i=v.value,c(1,o,i)}),c(x)});
