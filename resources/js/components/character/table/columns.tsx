'use client';

import { DataTableColumnHeader } from '@/components/data-table-column-header';
import { Badge } from '@/components/ui/badge';
import { ColumnDef } from '@tanstack/react-table';

export type Character = {
    name: string;
    level: number;
    sex_name: string;
    vocation_name: string;
    outfit_image_url: string;
};

export const columns: ColumnDef<Character>[] = [
    {
        header: 'Outfit',
        cell: ({ row }) => {
            return (
                <img
                    className="h-12 w-12 rounded-lg border border-gray-200 bg-gray-50 object-contain"
                    loading="lazy"
                    decoding="async"
                    src={row.original.outfit_image_url}
                    alt={row.original.name}
                />
            );
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
            return <Badge variant="outline">{row.original.vocation_name}</Badge>;
        },
    },
    {
        header: 'Sex',
        cell: ({ row }) => {
            return <Badge variant="secondary">{row.original.sex_name}</Badge>;
        },
    },
];
