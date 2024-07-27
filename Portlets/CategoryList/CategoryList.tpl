{if $isPreview}
    <div class="opc-CategoryList" style="{$instance->getStyleString()}">
        CategoryList
    </div>
{else}
    {$categories = $portlet->getFilteredCategories($instance)}

    {if $categories|count > 0}

        {if $inContainer === false}
            <div class="container-fluid">
            {/if}

            <div style="{$instance->getStyleString()}" class="row {$instance->getStyleClasses()}">
                {foreach $categories as $category}
                    <div class="col-md-3">
                        <a href="{$category['category_url']}" target="_blank">
                            <img src="{$category['image_url']}" alt="{$category['cName']}">
                        </a>
                        <a href="{$category['category_url']}" target="_blank">
                            <span>{$category['cName']}</span>
                        </a>
                    {$currentIteration = $category@iteration}
                    {if $currentIteration % 4 == 0}
                        </div><div class="clearfix"></div>
                    {else}
                        </div>
                    {/if}
                {/foreach}
            </div>
            {if $inContainer === false}
            </div>
        {/if}
        {inline_script}
        
        {/inline_script}

    {/if}
{/if}
