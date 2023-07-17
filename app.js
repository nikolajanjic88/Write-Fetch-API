const createBtn = document.getElementById('createBtn');
const modal = document.getElementById('modal');
const updateModal = document.getElementById('updateModal');
const closeBtn = document.getElementById('closeBtn');
const updateCloseBtn = document.getElementById('update-closeBtn');
const saveBtn = document.getElementById('saveBtn');
const updateBtn = document.getElementById('updateBtn');
const alert = document.getElementById('alert');

createBtn.addEventListener('click', () => {
  modal.style.display = 'flex';
});

closeBtn.addEventListener('click', () => {
  modal.style.display = 'none';
});

updateCloseBtn.addEventListener('click', () => {
  updateModal.style.display = 'none';
});

let output = '';

async function read() {
  const response = await fetch('http://localhost/api/project/php/read.php');
  const data = await response.json();
  if(data.message)
  {
    document.getElementById('table').style.display = 'none';
    output = `<h2>${data.message}</h2>`;
    document.getElementById('container').innerHTML = output;
  } else {
    const res = await data.data;
    res.forEach(item => {
      output += `
            <tr>
              <td>${item.name}</td>
              <td>${item.country}</td>
              <td>${item.age}</td>
              <td>${item.created_at}</td>
              <td><button class="btn btn-success" onclick="edit(${item.id})">Edit</button></td>
              <td><button class="btn btn-danger" onclick="deleteData(${item.id})">Delete</button></td>
            </tr>`
    });
    document.getElementById('tbody').innerHTML = output;
  }  
}

saveBtn.addEventListener('click', async () => {
  const name = document.getElementById('name').value;
  const country = document.getElementById('country').value;
  const age = document.getElementById('age').value;
  const response = await fetch('http://localhost/api/project/php/insert.php', {
    method: "POST",
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({name: name, country: country, age: age})
  });
  const data = await response.json();
  if(data.success)
  {
    alert.style.display = 'block';
    document.getElementById('alert-message').innerText = data.success;
    modal.style.display = 'none';  
  }
  if(data.error)
  {
    document.getElementById('alert-danger').style.display = 'block';
    document.getElementById('alert-danger-message').innerText = data.error;
  }
});


async function deleteData(id)
{
  const response = await fetch('http://localhost/api/project/php/delete.php', {
    method: "DELETE",
    body: JSON.stringify({id: id})
  });
  const data = await response.json();
  if(data.message === 'success')
  {
    location.reload();
  } else {
    alert(data.message);
  }
}

async function edit(id)
{
  updateModal.style.display = 'flex';
  const response = await fetch(`http://localhost/api/project/php/edit.php?id=${id}`);
  const data = await response.json();
  document.getElementById('id').value = data.id;
  document.getElementById('update_name').value = data.name;
  document.getElementById('update_country').value = data.country;
  document.getElementById('update_age').value = data.age;
}

updateBtn.addEventListener('click', async () => {
  const id = document.getElementById('id').value;
  const name = document.getElementById('update_name').value;
  const country = document.getElementById('update_country').value;
  const age = document.getElementById('update_age').value;
  const response = await fetch('http://localhost/api/project/php/update.php', {
    method: "POST",
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({id: id, name: name, country: country, age: age})   
  });
  const data = await response.json();
  if(data.success)
  {
    updateModal.style.display = 'none';
    location.reload();
  } else {
    document.getElementById('update-alert-danger').style.display = 'block';
    document.getElementById('update-alert-danger-message').innerText = data.error;
  }
});

read();
