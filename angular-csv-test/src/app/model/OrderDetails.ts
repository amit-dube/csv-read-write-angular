export interface OrderDetails {
    isSelected: boolean;
    id: number;
    name:string;
    state:string;
    zip:string;
    amount:string;
    qty:string;
    item:string;
    isEdit: boolean;
  }
  
  export const OrderDetailsColumns = [
    {
      key: 'isSelected',
      type: 'isSelected',
      label: '',
    },
    {
      key: 'id',
      type: 'text',
      label: 'ID',
      required: true,
    },
    {
      key: 'name',
      type: 'text',
      label: 'Name',
      required: true,
    },
    {
      key: 'state',
      type: 'text',
      label: 'Sate',
      required: true,
    },
    {
      key: 'zip',
      type: 'text',
      label: 'Zip',
      required: true,
    },
    {
      key: 'amount',
      type: 'text',
      label: 'Amount',
      required: true,
    },
    {
      key: 'qty',
      type: 'text',
      label: 'Qty',
      required: true,
    },
    {
      key: 'item',
      type: 'text',
      label: 'Item',
      required: true,
    },
    {
      key: 'isEdit',
      type: 'isEdit',
      label: 'Actions',
    },
  ];