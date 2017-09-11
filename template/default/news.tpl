<form name="news" action="news.php?a={a}{id}" method="post"  enctype="multipart/form-data">
                <table>
                <tr><td>
                    <label for="title">{title}
                        <input type="text" value="{titleV}" title="{titleT}" accesskey="t" class="inputL" size="50" name="title" />
                    </label>
                </td></tr>
                <tr><td>
                    <label for="desc">
                    <textarea name="desc">{content}</textarea>
                    </label>
                </td></tr>
                <tr><td>
                    <label for="file">{image} 
                        <input type="file" value="" title="{imageT}" accesskey="f" size="350" name="file" />
                    </label>
                </td></tr>
                <tr><td>
                    {bSubmit}
                </td></tr>
                </table>
</form>