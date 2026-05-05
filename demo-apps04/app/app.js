const rooms = [
  { id: 1, name: "Deluxe Suite", price: 200, img: "https://via.placeholder.com/200x150" },
  { id: 2, name: "Standard Room", price: 120, img: "https://via.placeholder.com/200x150" },
  { id: 3, name: "Family Suite", price: 250, img: "https://via.placeholder.com/200x150" },
];

function renderRooms() {
  const list = document.getElementById('roomList');
  rooms.forEach(room => {
    const card = document.createElement('div');
    card.className = 'room-card';
    card.innerHTML = `
      <img src="${room.img}" alt="${room.name}" style="width:100%;height:auto;"/>
      <h3>${room.name}</h3>
      <p>Price: $${room.price}/night</p>
    `;
    list.appendChild(card);
  });

  const select = document.getElementById('room');
  rooms.forEach(room => {
    const opt = document.createElement('option');
    opt.value = room.id;
    opt.textContent = `${room.name} ($${room.price})`;
    select.appendChild(opt);
  });
}

function handleBooking(event) {
  event.preventDefault();
  const name = document.getElementById('name').value;
  const email = document.getElementById('email').value;
  const roomId = document.getElementById('room').value;
  const checkin = document.getElementById('checkin').value;
  const checkout = document.getElementById('checkout').value;
  const room = rooms.find(r => r.id == roomId);
  const confirmation = document.getElementById('confirmation');
  confirmation.innerHTML = `<h3>Booking Confirmed!</h3>
    <p>Thank you, ${name}. Your booking for a ${room.name} from ${checkin} to ${checkout} has been received.</p>`;
  confirmation.classList.remove('hidden');
  document.getElementById('bookingForm').reset();
}

document.addEventListener('DOMContentLoaded', () => {
  renderRooms();
  document.getElementById('bookingForm').addEventListener('submit', handleBooking);
});
