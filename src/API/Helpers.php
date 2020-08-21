<?php

declare(strict_types=1);

namespace C14r\Directus\API;

class Helpers
{
    /**
     * Single
     * 
     * Using single the first element will be returned.
     * Useful for selecting a single item based on filters and search queries.
     * Will force limit to be 1.
     * 
     * @see https://docs.directus.io/api/query/single.html
     * @param mixed $bool   Return the result as if it was a single item.
     * @return string
     */
    public static function single($bool = true): string
    {
        return ($bool) ? '1' : '0';
    }

    /**
     * Fields
     * 
     * fields is a CSV of columns to include in the result.
     * This parameter supports dot notation to request nested relational fields.
     * You can also use a wildcard (*) to include all fields at a specific depth
     * 
     * @see https://docs.directus.io/api/query/fields.html
     * @param string|array $fields  Control what fields are being returned in the object.
     * @return string
     */
    public static function fields($fields): string
    {
        return static::_join($fields);
    }

    /**
     * Limit
     * 
     * Using limit can be set the maximum number of items that will be returned.
     * You can also use -1 to return all items, bypassing the default limits.
     * The default limit is set to 100.
     * 
     * @see https://docs.directus.io/api/query/limit.html
     * @param mixed $limit  A limit on the number of objects that are returned. Default is 100.
     * @return integer
     */
    public static function limit($limit): int
    {
        return static::_int($limit);
    }

    /**
     * Offset
     * 
     * Using offset the first offset number of items can be skipped.
     * 
     * @see https://docs.directus.io/api/query/offset.html
     * @param mixed $offset    How many items to skip when fetching data. Default is 0.
     * @return integer
     */
    public static function offset($offset): int
    {
        return static::_int($offset);
    }

    /**
     * Page
     * 
     * Using page along with limit can set the maximum number of items that will be returned grouped by pages.
     * @see https://docs.directus.io/api/query/page.html
     * @param mixed $page   Cursor for use in pagination. Often used in combination with limit.
     * @return integer
     */
    public static function page($page): int
    {
        return static::_int($page);
    }

    /**
     * Metadata
     * 
     * The meta parameter is a CSV of metadata fields to include.
     * This parameter supports the wildcard (*) to return all metadata fields.
     *
     * Posible values:
     * 
     *   collection   - The name of the collection
     *   type         - If its a collection or an item  
     *   result_count - Number of items returned in this response
     *   total_count  - Total number of items in this collection
     *   status_count - Number of items per status
     *   filter_count - Number of items matching the filter query
     *
     * @see https://docs.directus.io/api/query/meta.html
     * @param string|array $meta    What metadata to return in the response.
     * @return string
     */
    public static function meta($meta = '*'): string
    {
        if(is_string($meta) and ($meta == 'all' or $meta == '*'))
        {
            $meta = ['collection', 'type', 'result_count', 'total_count', 'status_count', 'filter_count'];
        }

        return static::_join($meta);
    }

    /**
     * Status
     * 
     * This parameter is useful for filtering items by their status value.
     * It is only used when the collection has a field with the status type.
     * The value should be a CSV.
     * 
     * By default all statuses are included except those marked as soft_delete.
     * To include statuses marked as soft_delete, they should be explicitly requested or an asterisk wildcard (*) should be used.
     * 
     * @see https://docs.directus.io/api/query/status.html
     * @param string|array $status  Filter items by the given status.
     * @return string
     */
    public static function status($status = '*'): string
    {
        return static::_join($status);
    }

    /**
     * Sorting
     * 
     * sort is a CSV of fields used to sort the fetched items.
     * Sorting defaults to ascending (ASC) order but a minus sign (-) can be used to reverse this to descending (DESC) order.
     * Fields are prioritized by their order in the CSV. You can also use a ? to sort randomly.
     * 
     * @see https://docs.directus.io/api/query/sort.html
     * @param mixed $sort  How to sort the returned items.
     * @return string
     */
    public static function sort($sort): string
    {
        if (is_array($sort)) {
            $newSort = [];

            foreach ($sort as $value) {
                if (is_array($value)) {
                    $dir = strtolower($value[1]);

                    if ($dir == '+' or $dir == 'a' or $dir == 'asc' or $dir == 'ascending') {
                        $newSort[] = $value[0];
                    } else {
                        $newSort[] = '-' . $value[0];
                    }
                } else {
                    $newSort[] = $value;
                }
            }

            return implode(',', $newSort);
        }

        return $sort;
    }

    /**
     * Q (search query)
     * 
     * The q parameter allows you to perform a search on all string and number type fields within a collection.
     * It's an easy way to search for an item without creating complex field filters – though it is far less optimized.
     * It only searches the root item's fields, related item fields are not included.
     * 
     * @see https://docs.directus.io/api/query/q.html
     * @param string $q Filter by items that contain the given search query in one of their fields.
     * @return string
     */
    public static function q(string $q): string
    {
        return $q;
    }

    /**
     * Filter
     * 
     * Used to search items in a collection that matches the filter's conditions.
     * Filters follow the syntax filter[<field-name>][<operator>]=<value>.
     * The field-name supports dot-notation to filter on nested relational fields.
     * 
     * @see https://docs.directus.io/api/query/filter.html
     * @param array $filter Select items in collection by given conditions.
     * @return void
     */
    public static function filter(array $filter)
    {
        return $filter;
    }

    /**
     * Casts the mixed value to an int.
     *
     * @param mixed $value
     * @return integer
     */
    private static function _int($value): int
    {
        return (int) $value;
    }

    /**
     * Combines the given array to a comma-separated-list.
     *
     * @param string|array $value
     * @return string
     */
    private static function _join($value): string
    {
        return is_array($value) ? implode(',', $value) : $value;
    }
}
