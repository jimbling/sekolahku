document.addEventListener("DOMContentLoaded",function(){const r=document.getElementById("gtk-skeleton"),i=document.querySelector("#gtk-container"),c=document.querySelector("#pagination-controls");let m=1;function s(o){if(isNaN(o)||o<1){console.error("Invalid page number");return}fetch(`/api/gtk?page=${o}`).then(e=>{if(!e.ok)throw new Error("Network response was not ok");return e.json()}).then(e=>{r&&(r.style.display="none"),i.innerHTML="",e.data.forEach(t=>{const a=document.createElement("div");a.className="card bg-white shadow-md rounded-lg overflow-hidden relative";let l;t.photo?l="/storage/"+t.photo:t.gender==="F"?l="/storage/images/illustrasi/gtk-wanita.jpg":t.gender==="M"?l="/storage/images/illustrasi/gtk-pria.jpg":l="https://via.placeholder.com/400",a.innerHTML=`
                        <div class="bg-gradient-to-r from-purple-300 via-pink-300 to-blue-300 h-20 flex justify-center items-end" data-aos="fade-in">
                            <div class="relative w-24 h-24 -mb-12">
                                <img src="${l}"
                                    alt="Foto GTK"
                                    class="w-full h-full rounded-full object-cover border-4 border-white shadow-md">
                            </div>
                        </div>
                        <div class="pt-16 pb-6 px-4 bg-gray-100 rounded-b-lg flex flex-col items-center">
                            <h2 class="text-lg font-semibold mb-2 text-center">${t.full_name}</h2>
                            <button class="bg-purple-500 text-white py-2 px-4 rounded mt-2 w-full" data-modal-id="${t.id}">
                                Lihat Detail
                            </button>
                        </div>
                    `,i.appendChild(a)}),p(e),document.querySelectorAll("[data-modal-id]").forEach(t=>{t.addEventListener("click",()=>{const a=t.dataset.modalId;u(a)})})}).catch(e=>{console.error("Error:",e)})}function u(o){fetch(`/api/gtk/${o}`).then(e=>e.json()).then(e=>{let n=document.querySelector(`#modal-${o}`);n?(n.querySelector(".modal-content").innerHTML=`
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>
                        <h2 class="text-xl font-semibold mb-4">${e.full_name}</h2>
                        <p class="mb-1"><strong>Jenis Kelamin:</strong> ${e.gender==="M"?"Pria":"Perempuan"}</p>
                        <p class="mb-1"><strong>Status Induk:</strong> ${e.parent_school_status===1?"INDUK":"NON INDUK"}</p>
                        <p class="mb-1"><strong>Status GTK:</strong> ${e.gtk_status}</p>
                    `,n.querySelector(".modal-image img").src=d(e)):(n=document.createElement("dialog"),n.id=`modal-${o}`,n.className="modal",n.innerHTML=`
                        <div class="modal-box flex">
                            <div class="modal-content flex-1 p-4">
                                <form method="dialog">
                                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                </form>
                                <h2 class="text-xl font-semibold mb-4">${e.full_name}</h2>
                                <p class="mb-1"><strong>Jenis Kelamin:</strong> ${e.gender==="M"?"Pria":"Perempuan"}</p>
                                <p class="mb-1"><strong>Status Induk:</strong> ${e.parent_school_status===1?"INDUK":"NON INDUK"}</p>
                                <p class="mb-1"><strong>Status GTK:</strong> ${e.gtk_status}</p>
                            </div>
                            <div class="modal-image flex-1 p-4">
                                <img src="${d(e)}"
                                     alt="Foto GTK"
                                     class="w-full h-auto object-cover rounded-lg shadow-md max-w-xs">
                            </div>
                        </div>
                    `,document.body.appendChild(n)),n.showModal(),document.querySelectorAll('button[formmethod="dialog"]').forEach(a=>{a.addEventListener("click",()=>{const l=a.closest("dialog");l&&l.close()})})}).catch(e=>{console.error("Error:",e)})}function d(o){return o.photo?"/storage/"+o.photo:o.gender==="F"?"/storage/images/illustrasi/gtk-wanita.jpg":o.gender==="M"?"/storage/images/illustrasi/gtk-pria.jpg":"https://via.placeholder.com/150"}function p(o){c.innerHTML="";const e=document.createElement("div");if(e.className="join",o.prev_page_url){const t=document.createElement("button");t.className="join-item btn",t.textContent="«",t.addEventListener("click",a=>{a.preventDefault(),s(o.current_page-1)}),e.appendChild(t)}const n=document.createElement("button");if(n.className="join-item btn",n.textContent=`Page ${o.current_page}`,e.appendChild(n),o.next_page_url){const t=document.createElement("button");t.className="join-item btn",t.textContent="»",t.addEventListener("click",a=>{a.preventDefault(),s(o.current_page+1)}),e.appendChild(t)}c.appendChild(e)}s(m)});
