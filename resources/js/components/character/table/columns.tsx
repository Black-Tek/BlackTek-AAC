'use client';

import { DataTableColumnHeader } from '@/components/data-table-column-header';
import { Badge } from '@/components/ui/badge';
import { ColumnDef } from '@tanstack/react-table';

export type Character = {
    id: number;
    name: string;
    sex: number;
    vocation: number;
    town_id: number;
    looktype: number;
    level: number;
    sex_name: string;
    vocation_name: string;
    outfit_image_url: string;
};

export const columns: ColumnDef<Character>[] = [
    {
        header: 'Outfit',
        cell: ({ row }) => {
            const outfit = row.original.outfit_image_url;
            const name = row.original.name;
            return <img src={outfit} alt={name} className="h-12 w-12 rounded-lg border border-gray-200 bg-gray-50 object-contain" />;
        },
    },
    {
        accessorKey: 'name',
        header: ({ column }) => <DataTableColumnHeader column={column} title="Name" />,
        cell: ({ row }) => {
            return <div className="font-medium">{row.getValue('name')}</div>;
        },
    },
    {
        accessorKey: 'level',
        header: ({ column }) => <DataTableColumnHeader column={column} title="Level" />,
        cell: ({ row }) => {
            return <div className="font-medium">{row.getValue('level')}</div>;
        },
    },
    {
        header: 'Vocation',
        cell: ({ row }) => {
            const vocation_name = row.original.vocation_name;
            return <Badge variant="outline">{vocation_name}</Badge>;
        },
    },
    {
        header: 'Sex',
        cell: ({ row }) => {
            const sex_name = row.original.sex_name;
            return <Badge variant="secondary">{sex_name}</Badge>;
        },
    },
];
