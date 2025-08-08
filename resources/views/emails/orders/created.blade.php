<x-mail::message>
# Ada pesanan baru!
## **Nomor Pesanan:** {{ $order->id_order }}

Informasi Klien:
- **Nama:** {{ $order->buyer_name }}
- **Email:** {{ $order->buyer_email }}
- **No Whatsapp:** {{ $order->buyer_whatsapp }}

Detail Pesanan :
- **Freelancer:** {{ $order->freelancer->name }}
- **Jasa:** {{ $order->package->subcategory->name }}
- **Paket:** {{ $order->package->title }}
</x-mail::message>
