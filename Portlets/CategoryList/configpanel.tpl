<div id="cb-category-filter-section" style="display: {if ($instance->getProperty('cb-category-source') == 'filter')}block;{else}none;{/if}">
    <label>{__('All categories')}</label>
    <div class="cb-filters-section">
        <div class="cb-filters-section-inner">
            <div class="row">
                {foreach $categories as $category}
                    <div class="col-md-4">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" name="categories[]" type="checkbox" value="{$category->kKategorie}" id="cb-category-{$category->kKategorie}" {if in_array($category->kKategorie, $selectedCategories)}checked{/if}>
                            <label class="custom-control-label" for="cb-category-{$category->kKategorie}">{$category->cName}</label>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>

