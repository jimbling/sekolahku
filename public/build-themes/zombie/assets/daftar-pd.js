document.addEventListener("DOMContentLoaded",()=>{document.getElementById("filterButton").addEventListener("click",function(){let l=document.getElementById("academic_year").value,s=document.getElementById("classroom").value;fetch("/pd/filter",{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:JSON.stringify({academic_year:l,classroom:s})}).then(t=>t.json()).then(t=>{let n=document.querySelector("#studentsCardsContainer");n.innerHTML="";let d=document.querySelector("#alertContainer"),c=document.querySelector("#alertMessage"),i=!1;Object.values(t).forEach((e,m)=>{e.anggota_rombels.forEach(r=>{if((!l||r.rombel.academic_years_id==l)&&(!s||r.rombel.classroom_id==s)){i=!0;let a=document.createElement("div"),u=r.rombel.classroom.name.split(" ").pop(),o;e.photo?o=`/storage/${e.photo}`:o=e.gender==="M"?"/storage/images/illustrasi/male.png":"/storage/images/illustrasi/female.png";let g=e.gender==="M"?"Laki-Laki":"Perempuan";a.className="bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden flex flex-col",a.setAttribute("data-aos","fade-up"),a.setAttribute("data-aos-delay",`${m*100}`),a.innerHTML=`
                                <div class="p-4 flex flex-1 items-start"> <!-- Flex untuk konten -->
                                    <div class="flex-shrink-0">
                                        <img src="${o}" alt="${e.name}" class="w-24 h-42 object-cover rounded-md border border-gray-300">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">${e.name}</h3>
                                        <p class="mt-1 text-sm text-gray-500">No Induk Siswa: ${e.nis}</p>
                                        <p class="mt-2 text-sm text-gray-500">Tahun Pelajaran: ${r.rombel.academic_year.academic_year}</p>
                                        <p class="mt-1 text-sm text-gray-500">Kelas: ${u}</p>
                                        <p class="mt-1 text-sm text-gray-500">Jenis Kelamin: ${g}</p> <!-- Label jenis kelamin -->
                                    </div>
                                </div>

                            `,n.appendChild(a)}})}),i?d.classList.add("hidden"):(c.textContent="Tidak ada hasil ditemukan.",d.classList.remove("hidden"))}).catch(t=>{console.error("Error:",t)})}),document.getElementById("alertCloseButton").addEventListener("click",function(){document.getElementById("alertContainer").classList.add("hidden")})});
